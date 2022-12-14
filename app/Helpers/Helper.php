<?php

namespace App\Helpers;

use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleUser;
use App\Models\Role;


class Helper{
  // public static function hash($str,$length=10,$start=0)
  // {
  //
  //   return substr(md5(date('dMY')."VEP".$str),$start,$length);
  // }

  public static function parseUrl($url,$removePublic = true)
  {
    if ($removePublic) {
      return str_replace("public/","",url($url));
    }
    return url($url);
  }

  public static function hash($id,$length=10)
  {
      $key = 'App123';
      $hash = new Hashids($key, $length);
      return $hash->encode($id);
  }

  public static function decodeHash($str, $toString = true,$targetUrl=null)
  {
      $key = 'App123';
      $hash = new Hashids($key, strlen($str));
      $decoded = $hash->decode($str);
      return $toString ? implode(',', $decoded) : $decoded;
  }

  public static function generateRandomString($type = "string",$length = 12)
  {
    if ($type == "string") {
      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    elseif ($type == "all") {
      $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . 'abcdefghijklmnopqrstuvwxyz0123456789';
    }
    elseif ($type == "number") {
      $characters = '0123456789';
    }
    $charactersLength = strlen($characters);
    $randomString  = '';

    for ($i=0; $i < $length ; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public static function getUserRole()
  {
    $userId = Auth::id();
    $roleUser = RoleUser::where('user_id', $userId)->first();
    $role = Role::find($roleUser['role_id']);

    return $role['name'];
  }


 //    public static function displayError($errors)
 //    {
 //        foreach ($errors as $err) {
 //            $data[] = $err;
 //        }
 //        return '
 //                <div class="alert alert-danger alert-styled-left alert-dismissible">
	// 								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
	// 								<span class="font-weight-semibold">Oops!</span> '.
 //        implode(' ', $data).'
	// 						    </div>
 //                ';
 //    }
 //
 //    public static function getAppCode()
 //    {
 //        return 'QS';
 //    }
 //
 //    public static function getDefaultUserImage()
 //    {
 //        return asset('global_assets/images/user.png');
 //    }
 //
 //    public static function getPanelOptions()
 //    {
 //        return '    <div class="header-elements">
 //                    <div class="list-icons">
 //                        <a class="list-icons-item" data-action="collapse"></a>
 //                        <a class="list-icons-item" data-action="remove"></a>
 //                    </div>
 //                </div>';
 //    }
 //
 //    public static function displaySuccess($msg)
 //    {
 //        return '
 // <div class="alert alert-success alert-bordered">
 //                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button> '.
 //        $msg.'  </div>
 //                ';
 //    }
 //
 //    public static function getTeamSA()
 //    {
 //        return ['admin', 'super_admin'];
 //    }
 //
 //    public static function getTeamAccount()
 //    {
 //        return ['admin', 'super_admin', 'accountant'];
 //    }
 //
 //    public static function getTeamSAT()
 //    {
 //        return ['admin', 'super_admin', 'teacher'];
 //    }
 //
 //    public static function getTeamAcademic()
 //    {
 //        return ['admin', 'super_admin', 'teacher', 'student'];
 //    }
 //
 //    public static function getTeamAdministrative()
 //    {
 //        return ['admin', 'super_admin', 'accountant'];
 //    }
 //

 //
 //    public static function getUserRecord($remove = [])
 //    {
 //        $data = ['name', 'email', 'phone', 'phone2', 'dob', 'gender', 'address', 'bg_id', 'nal_id', 'state_id', 'lga_id'];
 //
 //        return $remove ? array_values(array_diff($data, $remove)) : $data;
 //    }
 //
 //    public static function getStaffRecord($remove = [])
 //    {
 //        $data = ['emp_date',];
 //
 //        return $remove ? array_values(array_diff($data, $remove)) : $data;
 //    }
 //
 //    public static function getStudentData($remove = [])
 //    {
 //        $data = ['my_class_id', 'section_id', 'my_parent_id', 'dorm_id', 'dorm_room_no', 'year_admitted', 'house', 'age'];
 //
 //        return $remove ? array_values(array_diff($data, $remove)) : $data;
 //
 //    }
 //

 //
 //    public static function userIsTeamAccount()
 //    {
 //        return in_array(Auth::user()->user_type, self::getTeamAccount());
 //    }
 //
 //    public static function userIsTeamSA()
 //    {
 //        return in_array(Auth::user()->user_type, self::getTeamSA());
 //    }
 //
 //    public static function userIsTeamSAT()
 //    {
 //        return in_array(Auth::user()->user_type, self::getTeamSAT());
 //    }
 //
 //    public static function userIsAcademic()
 //    {
 //        return in_array(Auth::user()->user_type, self::getTeamAcademic());
 //    }
 //
 //    public static function userIsAdministrative()
 //    {
 //        return in_array(Auth::user()->user_type, self::getTeamAdministrative());
 //    }
 //
 //    public static function userIsAdmin()
 //    {
 //        return (Auth::user()->user_type == 'admin') ? true : false;
 //    }
 //
 //    public static function getUserType()
 //    {
 //        return Auth::user()->user_type;
 //    }
 //
 //    public static function userIsSuperAdmin()
 //    {
 //        return (Auth::user()->user_type == 'super_admin') ? true : false;
 //    }
 //
 //    public static function userIsStudent()
 //    {
 //        return (Auth::user()->user_type == 'student') ? true : false;
 //    }
 //
 //    public static function userIsTeacher()
 //    {
 //        return (Auth::user()->user_type == 'teacher') ? true : false;
 //    }
 //
 //    public static function userIsParent()
 //    {
 //        return (Auth::user()->user_type == 'parent') ? true : false;
 //    }
 //
 //    public static function userIsStaff()
 //    {
 //        return in_array(Auth::user()->user_type, self::getStaff());
 //    }
 //
 //    public static function getStaff($remove=[])
 //    {
 //        $data =  ['super_admin', 'admin', 'teacher', 'accountant', 'librarian'];
 //        return $remove ? array_values(array_diff($data, $remove)) : $data;
 //    }
 //
 //    public static function userIsPTA()
 //    {
 //        return in_array(Auth::user()->user_type, self::getPTA());
 //    }
 //
 //    public static function userIsMyChild($student_id, $parent_id)
 //    {
 //        $data = ['user_id' => $student_id, 'my_parent_id' =>$parent_id];
 //        return StudentRecord::where($data)->exists();
 //    }
 //
 //    public static function getSRByUserID($user_id)
 //    {
 //        return StudentRecord::where('user_id', $user_id)->first();
 //    }
 //
 //    public static function getPTA()
 //    {
 //        return ['super_admin', 'admin', 'teacher', 'parent'];
 //    }
 //
 //    public static function filesToUpload($programme)
 //    {
 //        return ['birth_cert', 'passport',  'neco_cert', 'waec_cert', 'ref1', 'ref2'];
 //    }
 //
 //    public static function getPublicUploadPath()
 //    {
 //        return 'uploads/';
 //    }
 //
 //    public static function getUserUploadPath()
 //    {
 //        return 'uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
 //    }
 //
 //    public static function getUploadPath($user_type)
 //    {
 //        return 'uploads/'.$user_type.'/';
 //    }
 //
 //    public static function getFileMetaData($file)
 //    {
 //        //$dataFile['name'] = $file->getClientOriginalName();
 //        $dataFile['ext'] = $file->getClientOriginalExtension();
 //        $dataFile['type'] = $file->getClientMimeType();
 //        $dataFile['size'] = self::formatBytes($file->getClientSize());
 //        return $dataFile;
 //    }
 //
 //    public static function generateUserCode()
 //    {
 //        return substr(uniqid(mt_rand()), -7, 7);
 //    }
 //
 //    public static function formatBytes($size, $precision = 2)
 //    {
 //        $base = log($size, 1024);
 //        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
 //
 //        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
 //    }
 //
 //    public static function getSetting($type)
 //    {
 //        return Setting::where('type', $type)->first()->description;
 //    }
 //
 //    public static function getCurrentSession()
 //    {
 //        return self::getSetting('current_session');
 //    }
 //
 //    public static function getSystemName()
 //    {
 //        return self::getSetting('system_name');
 //    }
 //
 //    public static function findMyChildren($parent_id)
 //    {
 //        return StudentRecord::where('my_parent_id', $parent_id)->with(['user', 'my_class'])->get();
 //    }
 //
 //    public static function findTeacherSubjects($teacher_id)
 //    {
 //        return Subject::where('teacher_id', $teacher_id)->with('my_class')->get();
 //    }
 //
 //    public static function findStudentRecord($user_id)
 //    {
 //        return StudentRecord::where('user_id', $user_id)->first();
 //    }
 //
 //    public static function getMarkType($class_type)
 //    {
 //       switch($class_type){
 //           case 'J' : return 'junior';
 //           case 'S' : return 'senior';
 //           case 'N' : return 'nursery';
 //           case 'P' : return 'primary';
 //           case 'PN' : return 'pre_nursery';
 //           case 'C' : return 'creche';
 //           break;
 //       }
 //        return $class_type;
 //    }
 //
 //    public static function json($msg, $ok = TRUE, $arr = [])
 //    {
 //        return $arr ? response()->json($arr) : response()->json(['ok' => $ok, 'msg' => $msg]);
 //    }
 //
 //    public static function jsonStoreOk()
 //    {
 //        return self::json(__('msg.store_ok'));
 //    }
 //
 //    public static function jsonUpdateOk()
 //    {
 //        return self::json(__('msg.update_ok'));
 //    }
 //
 //    public static function storeOk($routeName)
 //    {
 //        return self::goWithSuccess($routeName, __('msg.store_ok'));
 //    }
 //
 //    public static function deleteOk($routeName)
 //    {
 //        return self::goWithSuccess($routeName, __('msg.del_ok'));
 //    }
 //
 //    public static function updateOk($routeName)
 //    {
 //        return self::goWithSuccess($routeName, __('msg.update_ok'));
 //    }
 //
 //    public static function goToRoute($goto, $status = 302, $headers = [], $secure = null)
 //    {
 //        $data = [];
 //        $to = is_array($goto) ? $goto[0] : $goto ?: 'dashboard';
 //        if(is_array($goto)){
 //            array_shift($goto);
 //            $data = $goto;
 //        }
 //        return app('redirect')->to(route($to, $data), $status, $headers, $secure);
 //    }
 //
 //    public static function goWithDanger($to = 'dashboard', $msg = NULL)
 //    {
 //        $msg = $msg ? $msg : __('msg.rnf');
 //        return self::goToRoute($to)->with('flash_danger', $msg);
 //    }
 //
 //    public static function goWithSuccess($to = 'dashboard', $msg)
 //    {
 //        return self::goToRoute($to)->with('flash_success', $msg);
 //    }
 //
 //    public static function getDaysOfTheWeek()
 //    {
 //        return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
 //    }

}
