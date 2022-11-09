<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Helper;

class PositionDatamenu extends Model
{
  protected $table = 'position_datamenu';
  protected $fillable = [
    'position_id',
    'datamenu',
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
