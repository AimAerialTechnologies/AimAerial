<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Helper;
use File;

class Drone extends Model
{
    protected $fillable = [
        'user_id',
        'model',
        'serial_num',
        'imei',
        'description',
        'image',
        'status',
    ];

    public function getHashedIdAttribute()
    {
      return Helper::hash($this->id);
    }

    public function getImageAttribute($value)
    {
      if (!$value) {
        $value = "public/uploads/dImage/drone.png";
      }
      $image_path = public_path(str_replace("public","",$value));
      if(!File::exists($image_path)) {
        $value = "public/uploads/dImage/drone.png";
      }
      return $value;
    }

    public function getParseImageAttribute()
    {
      return Helper::parseUrl($this->image);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
