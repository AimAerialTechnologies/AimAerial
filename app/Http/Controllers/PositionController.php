<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use App\Models\PositionDataaccess;
use App\Models\PositionDatamenu;
use App\Models\Role;
use App\Models\Permission;
use DB;
use Helper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
  public function index(Request $request)
  {
    $user = auth()->user();
    if (!$user->company) {
      $response['status'] = "error";
      $response['message'] = "No company found!";
      return redirect()->route('dashboard')->with($response['status'], $response['message']);
    }
    $columns = ['Drone ID', 'Image', 'Drone Model' , 'Serial Number' , 'IMEI', 'Description', 'Owner', 'Status', 'Drone URL', 'QR Code'];
    $data['columns'] = $columns;
    $data['positions'] = Position::where('company_id', $user->company->id)->get();
    // dd($data['positions']);


    return view('admin.position.index',$data);
  }

  public function show($id)
  {
    // $permissions = Permission::all();
    // $roles = Role::all();
    $id = Helper::decodeHash($id);
    if ($id==null) {
      $response['status'] = "error";
      $response['message'] = "No data founded!";
      return redirect()->back()->with($response['status'], $response['message']);
    }
    $columns = ['Drone ID', 'Image', 'Drone Model' , 'Serial Number' , 'IMEI', 'Description', 'Owner', 'Status', 'Drone URL', 'QR Code'];
    $column_menus = ['Drone', 'Company', 'Position', 'User'];

    $position = Position::find($id);
    if (!$position) {
      $response['status'] = "error";
      $response['message'] = "Position not founded!";
      return redirect()->back()->with($response['status'], $response['message']);
    }
    // $data['permissions'] = $permissions;
    // dd(explode(",",$position->dataaccess->dataaccess));
    // dd($position->dataaccess->dataaccess);
    $data['position'] = $position;
    $data['columns'] = $columns;
    $data['column_menus'] = $column_menus;
    if ($position->dataaccess) {
      $data['dataAccess'] = explode(",",$position->dataaccess->dataaccess);
    }else {
      $data['dataAccess'] = [];
    }
    if ($position->hasDataMenu) {
      $data['dataMenu'] = explode(",",$position->hasDataMenu->datamenu);
    }else {
      $data['dataMenu'] = [];
    }
    // dd($data['dataAccess']);
    // dd($data);
    // dd($role->permissions->count());
    return view('admin.position.show',$data);

  }

  public function validation($input)
  {
    return Validator::make($input,[
      'name' => 'required',
      "dataaccess" => "required|array|min:1",
      "dataaccess.*" => "required|string|min:1",
    ]);
  }

  public function store(Request $request)
  {
    $input = $request->all();
    $validator = $this->validation($input);
    if($validator->fails())
    {
      $response['status'] = "errors";
      return redirect()->route('position.index')->with($response['status'],$validator->errors());
    }


    $position = new Position;
    $position->name = $input['name'];
    $position->company_id = auth()->user()->company->id;
    $position->save();

    if (Helper::decodeHash(implode(",",$input['dataaccess'])) != "0") {
      $dataaccess = ['dataaccess'=> implode(",",$input['dataaccess'])];
      $positionDataaccess = PositionDataaccess::updateOrCreate(
        ['position_id' => $position->id],
        $dataaccess
      );
    }


    $response['status'] = "success";
    $response['message'] = "Position Added Successfully!";

    return redirect()->route('position.index')->with($response['status'], $response['message']);
  }

  public function update(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input,[
      'edit_id' => 'required',
      'name' => 'required',
    ]);

    if ($validator->fails()) {
      $response['status'] = "errors";
      return redirect()->route('position.index')->with($response['status'],$validator->errors());
    }

    $input['edit_id'] = Helper::decodeHash($input['edit_id']);
    if ($input['edit_id']==null) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->route('position.index')->with($response['status'], $response['message']);
    }

    $position = Position::find($input['edit_id']);
    if (!$position) {
      $response['status'] = "error";
      $response['message'] = "Position not found!";
      return redirect()->route('position.index')->with($response['status'], $response['message']);
    }

    $data['name'] = $input['name'];

    $position->update($data);

    $response['status'] = "success";
    $response['message'] = "Position Updated Successfully!";

    return redirect()->route('position.index')->with($response['status'], $response['message']);
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
      return redirect()->route('position.index')->with($response['status'],$validator->errors());
    }
    $input['delete_id']=Helper::decodeHash($input['delete_id']);
    if ($input['delete_id']==null) {
      $response['status'] = "error";
      $response['message'] = "Position Not Found";
      return redirect()->route('position.index')->with($response['status'],$response['message']);
    }
    $drones = Position::find($input['delete_id']);
    if (!$drones) {
      $response['status'] = "error";
      $response['message'] = "Position Not Found";
      return redirect()->route('position.index')->with($response['status'],$response['message']);
    }

    $drones->delete();

    $response['status'] = "success";
    $response['message'] = "Position Deleted Successfully!";

    return redirect()->route('position.index')->with($response['status'], $response['message']);

  }

  public function updateDataAccess(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input, [
      "position" => "required",
      "dataaccess" => "required|array|min:1",
      "dataaccess.*" => "required|string|min:1",
    ]);
    if ($validator->fails()) {
      $response['status'] = "errors";
      return redirect()->back()->with($response['status'],$validator->errors());
    }

    $id = Helper::decodeHash($input['position']);
    if ($id==null) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->back()->with($response['status'], $response['message']);
    }

    $position = Position::find($id);
    if (!$position) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->back()->with($response['status'], $response['message']);
    }

    if (Helper::decodeHash(implode(",",$input['dataaccess'])) == "0") {
      $dataaccess = ['dataaccess'=> null];
      $positionDataaccess = PositionDataaccess::where('position_id',$id)->first();
      if ($positionDataaccess) {
        $positionDataaccess->delete();
      }
    }
    else {
      $dataaccess = ['dataaccess'=> implode(",",$input['dataaccess'])];
      $positionDataaccess = PositionDataaccess::updateOrCreate(
        ['position_id' => $id],
        $dataaccess
      );
    }

    $response['status'] = "success";
    $response['message'] = "Data Access Updated Successfully!";

    return redirect()->route('position.show',['position' => $input['position']])->with($response['status'], $response['message']);
    // dd($positionDataaccess);
  }

  public function updateDataMenu(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input, [
      "position" => "required",
      "datamenu" => "required|array|min:1",
      "datamenu.*" => "required|string|min:1",
    ]);
    if ($validator->fails()) {
      $response['status'] = "errors";
      return redirect()->back()->with($response['status'],$validator->errors());
    }

    $id = Helper::decodeHash($input['position']);
    if ($id==null) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->back()->with($response['status'], $response['message']);
    }

    $position = Position::find($id);
    if (!$position) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->back()->with($response['status'], $response['message']);
    }

    if (Helper::decodeHash(implode(",",$input['datamenu'])) == "0") {
      $datamenu = ['datamenu'=> null];
      $positionDatamenu = PositionDatamenu::where('position_id',$id)->first();
      if ($positionDatamenu) {
        $positionDatamenu->delete();
      }
    }
    else {
      $datamenu = ['datamenu'=> implode(",",$input['datamenu'])];
      $positionDatamenu = PositionDatamenu::updateOrCreate(
        ['position_id' => $id],
        $datamenu
      );
    }

    $response['status'] = "success";
    $response['message'] = "View Data Access Updated Successfully!";

    return redirect()->route('position.show',['position' => $input['position']])->with($response['status'], $response['message']);
    // dd($positionDataaccess);
  }
}
