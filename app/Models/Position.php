<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Helper;

class Position extends Model
{
  protected $table = 'position';
  protected $fillable = [
    'company_id',
    'name',
  ];

  public function getHashedIdAttribute()
  {
    return Helper::hash($this->id);
  }

  public function dataaccess()
  {
    return $this->hasOne(PositionDataaccess::class);
  }

  public function hasDataMenu()
  {
    return $this->hasOne(PositionDatamenu::class);
  }
}
