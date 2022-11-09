<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use App\Models\Position;
use App\Models\PositionUser;
use DB;
use Helper;

class UserController extends Controller
{

  public function validation($input)
  {
    return Validator::make($input,[
      'name' => 'required',
      'email' => 'required',
      'ic' => 'required',
      'company' => 'required',
      'role' => 'required',
      'position' => 'required',
    ]);
  }

  public function index(Request $request)
  {
    $data['users'] = User::all();
    $data['companies'] = Company::all();
    $data['roles'] = Role::all();

    $data['positions'] = Position::where('company_id', auth()->user()->company->id)->get();

    $role = auth()->user()->hasRole('Regulator');
    if ($role) {
      $data['users'] = User::where('company_id', auth()->user()->company->id)->get();
      $data['companies'] = Company::where('id', auth()->user()->company->id)->get();
    }
    // dd($data['users'][4]$user->hasPosition->position->name);
    return view('admin.users.index', $data);
  }

  public function show($id)
  {
    $id = Helper::decodeHash($id);
    if ($id==null) {
      $response['status'] = "error";
      $response['message'] = "No data founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }
    $data['user'] = User::find($id);

    // dd($data['user']->company);

    return view('admin.users.show',$data);
  }

  public function create()
  {
    return view('users');
  }

  public function store(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input,[
      'name' => 'required',
      'email' => 'required|unique:users',
      'ic' => 'required',
      'company' => 'required',
      'role' => 'required',
      'position' => 'required',
    ]);
    if($validator->fails())
    {
      $response['status'] = "errors";
      return redirect()->route('users.index')->with($response['status'],$validator->errors());
    }

    $input['company'] = Helper::decodeHash($input['company']);
    if ($input['company']==null) {
      $response['status'] = "error";
      $response['message'] = "No data founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }
    $input['position'] = Helper::decodeHash($input['position']);
    $position = Position::find($input['position']);
    if ($input['position']==null && $position == null) {
      $response['status'] = "error";
      $response['message'] = "No position founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }

    $user = new User;
    $user->name = $input['name'];
    $user->email = $input['email'];
    $user->ic = $input['ic'];
    $user->password = Hash::make($input['password']);
    $user->company_id = $input['company'];
    $user->assignRole($input['role']);
    $user->save();

    PositionUser::create([
      'position_id' => $position->id,
      'user_id' => $user->id,
    ]);

    $response['status'] = "success";
    $response['message'] = "User Added Successfully!";

    return redirect()->route('users.index')->with($response['status'], $response['message']);

  }

  public function edit(Request $request)
  {

    $input = $request->all();

    $validator = Validator::make($input,[
    'edit_id' => 'required',
    'name' => 'required',
    'email' => 'required',
    'ic' => 'required',
    'company' => 'required',
    'role' => 'required',
    'position' => 'required',
    ]);

    if ($validator->fails()) {
      $response['status'] = "errors";
      return redirect()->route('users.index')->with($response['status'],$validator->errors());
    }

    $input['edit_id'] = Helper::decodeHash($input['edit_id']);
    if ($input['edit_id']==null) {
      $response['status'] = "error";
      $response['message'] = "No data founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }
    $user = User::find($input['edit_id']);
    if (!$user) {
      $response['status'] = "error";
      $response['message'] = "User not founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }

    $input['company'] = Helper::decodeHash($input['company']);
    if ($input['company']==null) {
      $response['status'] = "error";
      $response['message'] = "No data founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }

    $input['position'] = Helper::decodeHash($input['position']);
    $position = Position::find($input['position']);
    if ($input['position']==null && $position==null) {
      $response['status'] = "error";
      $response['message'] = "No position founded!";
      return redirect()->route('users.index')->with($response['status'], $response['message']);
    }

    $user->update([
      "name" => $input['name'],
      "email" => $input['email'],
      "ic" => $input['ic'],
      "company_id" => $input['company'],
    ]);

    if ($user->hasPosition) {
      $userUpdate = $user->hasPosition->update([
        'position_id' => $position->id,
        'user_id' => $user->id,
      ]);
    }else {
      PositionUser::create([
        'position_id' => $position->id,
        'user_id' => $user->id,
      ]);
    }
    // PositionUser::where('')->update([
    //   'position_id' => $position->id,
    //   'user_id' => $user->id,
    // ]);

    $user->syncRoles($input['role']);

    $response['status'] = "success";
    $response['message'] = "User Updated Successfully!";

    return redirect()->route('users.index')->with($response['status'], $response['message']);
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
      return redirect()->route('users.index')->with($response['status'],$validator->errors());
    }
    $input['delete_id']=Helper::decodeHash($input['delete_id']);
    if ($input['delete_id']==null) {
      $response['status'] = "error";
      $response['message'] = "User Not Found";
      return redirect()->route('users.index')->with($response['status'],$response['message']);
    }
    $user = User::find($input['delete_id']);
    if (!$user) {
      $response['status'] = "error";
      $response['message'] = "User Not Found";
      return redirect()->route('users.index')->with($response['status'],$response['message']);
    }

    $user->delete();

    $response['status'] = "success";
    $response['message'] = "User Deleted Successfully!";

    return redirect()->route('users.index')->with($response['status'], $response['message']);

  }

  public function feedback(){

    return view('user.feedback');
  }

  public function contact(){

    return view('user.contact');
  }

}
