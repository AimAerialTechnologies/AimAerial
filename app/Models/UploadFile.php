<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;


class UploadFile extends Model
{

  public static function filename($filename=null,$filetype=null)
  {
    if ($filename==null) {
      $response['status'] = false;
      $response['message'] = "filename null";
      return $response;
    }
    if ($filetype==null) {
      $response['status'] = false;
      $response['message'] = "filetype null";
      return $response;
    }

    $timecode = "_".Helper::generateRandomString("number",5).strtotime("now");
    $filetype = ".".$filetype;

    $response['status'] = true;
    $response['data'] = str_replace(' ', '_', preg_replace('/[^\p{L}\p{N}\s]/u', '', $filename)).$timecode.$filetype;
    return $response;
  }

  public static function file($filename=null,$filetype=null)
  {
    if($filename==NULL || $filetype==NULL){
      return NULL;
    }
    $timecode = "_".Helper::generateRandomString("number",5).strtotime("now");
    $filetype = ".".$filetype;
    // $response = str_replace(' ', '_', preg_replace('/[^\p{L}\p{N}\s]/u', '', $filename)).$filetype;
    $filename = str_replace(",","_",$filename);
    $filename = str_replace("|","_",$filename);
    $response = str_replace(" ","_",$filename).$timecode.$filetype;
    return $response;
  }

  public static function trimWhitespace($filename=null,$filetype=null)
  {
    if($filename==NULL || $filetype==NULL){
      return NULL;
    }
    $filetype = ".".$filetype;
    $response = str_replace(" ","_",$filename).$filetype;
    return $response;
  }
}
