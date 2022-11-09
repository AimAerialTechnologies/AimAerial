<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;
use App\Models\User;
use Helper;

class Permission extends Model
{

    public function getHashedIdAttribute()
    {
      return Helper::hash($this->id);
    }

}
