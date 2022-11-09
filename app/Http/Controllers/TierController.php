<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use DB;
use Helper;
use Validator;


class TierController extends Controller
{
use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         // $this->middleware('permission:role-create', ['only' => ['create','store']]);
         // $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**

     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     */
    public function index(Request $request)
    {
        $roles = Role::all();

        $data['roles'] = $roles;
        return view('admin.tiers.index',$data);
        // return view('admin.tiers.index',compact('roles'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('tiers.index')
                        ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $role = Role::find($id);
        // $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        //     ->where("role_has_permissions.role_id",$id)
        //     ->get();
        $permissions = Permission::all();
        $roles = Role::all();
        $id = Helper::decodeHash($id);
        if ($id==null) {
          $response['status'] = "error";
          $response['message'] = "No data founded!";
          return redirect()->back()->with($response['status'], $response['message']);
        }

        $role = Role::find($id);
        if (!$role) {
          $response['status'] = "error";
          $response['message'] = "Role not founded!";
          return redirect()->back()->with($response['status'], $response['message']);
        }

        $data['permissions'] = $permissions;
        $data['role'] = $role;
        // dd($role->permissions->count());
        return view('admin.tiers.show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('roles.edit',compact('role','permission','rolePermissions'));
    }


    public function updateRole(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        "edit_id" => "required",
        "name" => "required|unique:roles,name," . $input['name'],
      ]);
      if ($validator->fails()) {
        $response['status'] = "errors";
        return redirect()->back()->with($response['status'],$validator->errors());
      }
      $input['edit_id'] = Helper::decodeHash($input['edit_id']);
      if ($input['edit_id']==null) {
        $response['status'] = "error";
        $response['message'] = "No data found!";
        return redirect()->back()->with($response['status'], $response['message']);
      }

      $role = Role::find($input['edit_id']);
      if (!$role) {
        $response['status'] = "error";
        $response['message'] = "No data found!";
        return redirect()->back()->with($response['status'], $response['message']);
      }
      $roleUpdate = $role->update([
        "name" => $input['name'],
      ]);

      if ($roleUpdate) {
        $response['status'] = "success";
        $response['message'] = "Role updated successfully";
      }else {
        $response['status'] = "error";
        $response['message'] = "A problem has been occurred while updating the role";
      }

      return redirect()->route('tiers.index')
      ->with($response['status'],$response['message']);
    }

    public function updateRolePermission(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        "role"    => "required",
        "permission"    => "required|array|min:1",
        "permission.*"  => "required|string|min:1",
      ]);
      if ($validator->fails()) {
        $response['status'] = "errors";
        return redirect()->back()->with($response['status'],$validator->errors());
      }

      $id = Helper::decodeHash($input['role']);
      if ($id==null) {
        $response['status'] = "error";
        $response['message'] = "No data found!";
        return redirect()->back()->with($response['status'], $response['message']);
      }

      $role = Role::find($id);
      if (!$role) {
        $response['status'] = "error";
        $response['message'] = "No data found!";
        return redirect()->back()->with($response['status'], $response['message']);
      }
      if (Helper::decodeHash($input['permission'][0]) == "0") {
        $role->syncPermissions([]);
        goto next;
      }

      foreach ($input['permission'] as $inpk => $inp) {
        $inp = Helper::decodeHash($inp);
        if ($inp==null) {
          $response['status'] = "error";
          $response['message'] = "No data found!";
          return redirect()->back()->with($response['status'], $response['message']);
        }

        $inpms = Permission::find($inp);
        if (!$inpms) {
          $response['status'] = "error";
          $response['message'] = "No data found!";
          return redirect()->back()->with($response['status'], $response['message']);
        }
        $permissions[] = $inpms;
      }

      $role->syncPermissions($permissions);

      next:

      $response['status'] = "success";
      $response['message'] = $role->name." permission updated successfully";
      return redirect()->back()->with($response['status'],$response['message']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
