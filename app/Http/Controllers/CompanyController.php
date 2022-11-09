<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use DB;
use Helper;

class CompanyController extends Controller
{

  public function validation($input)
  {
    return Validator::make($input,[
      'name' => 'required',
      'address' => 'required',
      'phone' => 'required',
      'desc' => 'required',
    ]);
  }

  public function index(Request $request)
  {
      $company = Company::all();
      return view('admin.company.index',compact('company'));
  }

  public function user()
  {
      $company = auth()->user()->company;
      return view('admin.company.show',compact('company'));
  }

  public function create()
  {
    return view('company');
  }

  public function store(Request $request)
  {
    $input = $request->all();
    $validator = $this->validation($input);

    if($validator->fails())
    {
      $response['status'] = "errors";
      return redirect()->route('company.index')->with($response['status'],$validator->errors());
    }

    $company = new Company;
    $company->name = $input['name'];
    $company->address = $input['address'];
    $company->phone = $input['phone'];
    $company->desc = $input['desc'];
    $company->save();

    $response['status'] = "success";
    $response['message'] = "Company Added Successfully!";

    return redirect()->route('company.index')->with($response['status'], $response['message']);
  }

  public function edit(Request $request)
  {

    $input = $request->all();

    $validator = Validator::make($input,[
      'edit_id' => 'required',
      'name' => 'required',
      'address' => 'required',
      'phone' => 'required',
      'desc' => 'required',
    ]);

    if ($validator->fails()) {
      $response['status'] = "errors";
      return redirect()->route('company.index')->with($response['status'],$validator->errors());
    }

    $input['edit_id'] = Helper::decodeHash($input['edit_id']);
    if ($input['edit_id']==null) {
      $response['status'] = "error";
      $response['message'] = "No data found!";
      return redirect()->route('company.index')->with($response['status'], $response['message']);
    }
    $company = Company::find($input['edit_id']);
    if (!$company) {
      $response['status'] = "error";
      $response['message'] = "Company not found!";
      return redirect()->route('company.index')->with($response['status'], $response['message']);
    }

    $company->update([
    "name" => $input['name'],
    "address" => $input['address'],
    "phone" => $input['phone'],
    "desc" => $input['desc']
    ]);

    $response['status'] = "success";
    $response['message'] = "Company Updated Successfully!";

    $role = auth()->user()->hasRole('Regulator');
    if ($role) {
      return redirect()->route('company.user')->with($response['status'], $response['message']);
    }

    return redirect()->route('company.index')->with($response['status'], $response['message']);
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
      return redirect()->route('company.index')->with($response['status'],$validator->errors());
    }
    $input['delete_id']=Helper::decodeHash($input['delete_id']);
    if ($input['delete_id']==null) {
      $response['status'] = "error";
      $response['message'] = "Company Not Found";
      return redirect()->route('company.index')->with($response['status'],$response['message']);
    }
    $company = Company::find($input['delete_id']);
    if (!$company) {
      $response['status'] = "error";
      $response['message'] = "Company Not Found";
      return redirect()->route('company.index')->with($response['status'],$response['message']);
    }

    $company->delete();

    $response['status'] = "success";
    $response['message'] = "Company Deleted Successfully!";

    return redirect()->route('company.index')->with($response['status'], $response['message']);

  }

}
