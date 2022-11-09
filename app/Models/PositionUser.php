<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Helper;

class PositionUser extends Model
{
  protected $table = 'position_user';
  protected $fillable = [
    'position_id',
    'user_id',
  ];

  public function getHashedIdAttribute()
  {
    return Helper::hash($this->id);
  }

  public function position()
  {
    return $this->belongsTo(Position::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
