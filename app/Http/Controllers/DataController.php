<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Company;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use DB;
use Helper;
use Validator;
use Illuminate\Support\Facades\Schema;

class DataController extends Controller
{

  public function index(Request $request)
  {
    $role = auth()->user()->hasRole('Regulator');
    $users = User::all();
    if ($role) {
      $data['users'] = User::where('company_id', auth()->user()->company->id)->get();
      $data['companies'] = Company::where('id', auth()->user()->company->id)->get();

      return view('admin.data.reg_index',$data);

    }

    else{

      $companies = Company::all();

      $data['companies'] = $companies;
      return view('admin.data.index',$data);
      // return view('admin.tiers.index',compact('roles'))
      //     ->with('i', ($request->input('page', 1) - 1) * 5);
      }

  }

  public function show($id)
  {
    $id = Helper::decodeHash($id);
    if ($id==null) {
      $response['status'] = "error";
      $response['message'] = "No data founded!";
      return redirect()->back()->with($response['status'], $response['message']);
    }

    $role = auth()->user()->hasRole('Regulator');
    if ($role) {
      $user = User::find($id);
      if (!$user) {
        $response['status'] = "error";
        $response['message'] = "No data founded!";
        return redirect()->back()->with($response['status'], $response['message']);
      }
      $columns = Schema::getColumnListing('drones');

      $data['columns'] = $columns;
      $data['user'] = $user;

      return view('admin.data.reg_show',$data);
    }

    else{

      $company = Company::find($id);
      if (!$company) {
        $response['status'] = "error";
        $response['message'] = "No data founded!";
        return redirect()->back()->with($response['status'], $response['message']);
      }
      $columns = Schema::getColumnListing('drones');

      $data['columns'] = $columns;
      $data['company'] = $company;
      // dd($data);

      return view('admin.data.show',$data);
    }
    }


}
