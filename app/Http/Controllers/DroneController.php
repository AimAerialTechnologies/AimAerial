<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Drone;
use App\Models\User;
use App\Models\UploadFile;
use QrCode;
use DB;
use Helper;
use File;

class DroneController extends Controller
{

  public function validation($input)
  {
    return Validator::make($input,[
      'image' => 'required|mimetypes:application/pdf,image/png,image/jpeg|max:5000',
      'model' => 'required',
      'serial_num' => 'required',
      'imei' => 'required',
      'description' => '',
      'status' => 'required',
    ],[
      'image.max' => 'The :attribute may not be greater than 5 MB',
    ]);
  }


  public function index(Request $request)
  {
      $data['drones'] = Drone::all();
      $data['users'] = User::all();
      $role = auth()->user()->hasRole('Regulator');
      if ($role) {
        $data['users'] = User::where('company_id', auth()->user()->company->id)->get();
        $data['drones'] = Drone::whereHas('user', function($q) {
            $q->whereHas("company")->where("company_id",auth()->user()->company->id);
        })->get();
        //
        // dd($data['drones'][0]->user->company);
      }
      elseif (auth()->user()->hasRole('User')) {
        // code...
        $data['drones'] = Drone::whereHas('user', function($q) {
            $q->where("user_id",auth()->user()->id);
        })->get();

        return view('user.drones.index',$data);
      }
      return view('admin.drones.index',$data);
  }

  public function user()
  {
      $drones = auth()->user()->drone;
      return view('admin.drones.show',compact('drones'));
  }

  public function gdrone($id)
  {
    $id = Helper::decodeHash($id);
    if ($id==null) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->route('drones.index')->with($response['status'], $response['message']);
    }
    $drones = Drone::find($id);
    if (!$drones) {
      $response['status'] = "error";
      $response['message'] = "Drone not found!";
      return redirect()->route('drones.index')->with($response['status'], $response['message']);
    }

    return view('admin.drones.detail',compact('drones'));

  }

  public function qrCode($id)
  {
    $id = Helper::decodeHash($id);
    if ($id==null) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->route('drones.index')->with($response['status'], $response['message']);
    }
    $drones = Drone::find($id);
    if (!$drones) {
      $response['status'] = "error";
      $response['message'] = "Drone not found!";
      return redirect()->route('drones.index')->with($response['status'], $response['message']);
    }

    $qrCode = QrCode::size(500)->format('png')->margin(1)->generate(route('drones.get',['id' => Helper::hash($drones->id,50)] ));

    return response($qrCode)->header('Content-Type', 'image/png');

  }

  public function create()
  {
    return view('drones');
  }

  public function updateStatus(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input,[
      'drone' => 'required',
      'status' => 'required|regex:(Enable|Disable)',
    ]);
    if($validator->fails())
    {
      $response['status'] = "errors";
      return redirect()->route('drones.index')->with($response['status'],$validator->errors());
    }

    $input['drone'] = Helper::decodeHash($input['drone']);
    $drone = Drone::find($input['drone']);
    if ($input['drone']==null && $drone==null) {
      $response['status'] = "error";
      $response['message'] = "No drone founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }


  }

  public function store(Request $request)
  {
    $input = $request->all();
    $validator = $this->validation($input);

    if($validator->fails())
    {
      $response['status'] = "errors";
      return redirect()->route('drones.index')->with($response['status'],$validator->errors());
    }

    $file_db_path = "public/uploads/dImage/";
    $file_store_path = public_path("uploads/dImage");
    $file = $input['image'];

    $filename1 = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $filetype1 = $file->getClientOriginalExtension();

    $encodedfilename = UploadFile::filename($filename1,$filetype1);
    if (!$encodedfilename['status']) {
      return redirect()->back()->with("error", $encodedfilename['message']);
    }
    $encodedfilename = $encodedfilename['data'];
    $stored = $file->move($file_store_path, $encodedfilename);

    if (!$stored) {
      $response['status'] = "error";
      $response['message'] = "Error saving the file.";

      return redirect()->back()->with($response['status'], $response['message']);
    }
    $drone_file = $file_db_path.$stored->getFilename();

    $drone = new Drone;
    $drone->image = $drone_file;
    $drone->model = $input['model'];
    $drone->imei = $input['imei'];
    $drone->serial_num = $input['serial_num'];
    $drone->description = $input['description'];
    $drone->status = $input['status'];
    $drone->user_id = auth()->user()->id;
    $drone->save();


    $response['status'] = "success";
    $response['message'] = "Drone Added Successfully!";

    return redirect()->route('drones.index')->with($response['status'], $response['message']);
  }

  public function edit(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input,[
      'edit_id' => 'required',
      'model' => 'required',
      'serial_num' => 'required',
      'imei' => 'required',
      'description' => 'required',
      'status' => 'required',
      'image' => 'mimetypes:application/pdf,image/png,image/jpeg|max:5000',
    ]);

    if ($validator->fails()) {
      $response['status'] = "errors";
      return redirect()->route('drones.index')->with($response['status'],$validator->errors());
    }

    $input['edit_id'] = Helper::decodeHash($input['edit_id']);
    if ($input['edit_id']==null) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->route('drones.index')->with($response['status'], $response['message']);
    }

    $drones = Drone::find($input['edit_id']);
    if (!$drones) {
      $response['status'] = "error";
      $response['message'] = "Drone not found!";
      return redirect()->route('drones.index')->with($response['status'], $response['message']);
    }

    if (isset($input['image'])) {
      $file_db_path = "public/uploads/dImage/";
      $file_store_path = public_path("uploads/dImage");
      $file = $input['image'];

      $filename1 = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $filetype1 = $file->getClientOriginalExtension();

      $encodedfilename = UploadFile::filename($filename1,$filetype1);
      if (!$encodedfilename['status']) {
        return redirect()->back()->with("error", $encodedfilename['message']);
      }
      $encodedfilename = $encodedfilename['data'];
      $stored = $file->move($file_store_path, $encodedfilename);

      if (!$stored) {
        $response['status'] = "error";
        $response['message'] = "Error saving the file.";

        return redirect()->back()->with($response['status'], $response['message']);
      }
      $image_path = public_path(str_replace("public","",$drones->image));
      if(File::exists($image_path)) {
        File::delete($image_path);
      }

      $data['image'] = $file_db_path.$stored->getFilename();
    }

    $data['model'] = $input['model'];
    $data['serial_num'] = $input['serial_num'];
    $data['imei'] = $input['imei'];
    $data['description'] = $input['description'];
    $data['status'] = $input['status'];
    $data['user_id'] = auth()->user()->id;

    $drones->update($data);

    $response['status'] = "success";
    $response['message'] = "Drone Updated Successfully!";

    return redirect()->route('drones.index')->with($response['status'], $response['message']);
  }

  public function destroy(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input,[
    'delete_id' => 'required',
    ]);

    if($validator->fails())
    {
      $response['status'] = "errors";
      return redirect()->route('drones.index')->with($response['status'],$validator->errors());
    }
    $input['delete_id']=Helper::decodeHash($input['delete_id']);
    if ($input['delete_id']==null) {
      $response['status'] = "error";
      $response['message'] = "Drone Not Found";
      return redirect()->route('drones.index')->with($response['status'],$response['message']);
    }
    $drones = Drone::find($input['delete_id']);
    if (!$drones) {
      $response['status'] = "error";
      $response['message'] = "Drone Not Found";
      return redirect()->route('drones.index')->with($response['status'],$response['message']);
    }

    $drones->delete();

    $response['status'] = "success";
    $response['message'] = "Drone Deleted Successfully!";

    return redirect()->route('drones.index')->with($response['status'], $response['message']);

  }

}
