<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Helper;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'phone',
        'address',
        'desc'
    ];

    public function getHashedIdAttribute()
    {
      return Helper::hash($this->id);
    }

    public function user()
    {
      return $this->hasMany(User::class);
    }
}
