<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;
use App\Models\User;
use Helper;

class Role extends Model
{
    // protected $fillable = [
    //     'user_id',
    //     'model',
    //     'serial_num',
    //     'imei',
    //     'description',
    //     'image',
    //     'status',
    // ];

    public function getHashedIdAttribute()
    {
      return Helper::hash($this->id);
    }

    public function getCountUserAttribute()
    {
      $name = $this->name;
      return User::whereHas('roles', function($q) use($name){
        $q->where('name', $name);
      })->get()->count();
    }

    public function getParseImageAttribute()
    {
      return Helper::parseUrl($this->image);
    }
}
