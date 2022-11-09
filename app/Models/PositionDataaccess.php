<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Helper;

class PositionDataaccess extends Model
{
  protected $table = 'position_dataaccess';
  protected $fillable = [
    'position_id',
    'dataaccess',
  ];

  public function getHashedIdAttribute()
  {
    return Helper::hash($this->id);
  }

  public function position()
  {
    return $this->belongsTo(Position::class);
  }
}
