<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Drone;
use Helper;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'password',
        'ic',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getHashedIdAttribute()
    {
      return Helper::hash($this->id);
    }
    //
    // public function password($password)
    // {
    //   $password = Helper::decodeHash($user->password);
    //   if ($password==null) {
    //     $response['status'] = "error";
    //     $response['message'] = "No data founded!";
    //     return $password;
    //   }
    // }

    public function role($id)
    {
      $user = User::find($id);
      if ($user->getRoleNames() && isset($user->getRoleNames()[0])) {
        return $user->getRoleNames()[0];
      }
      return $user;
    }

    public function drone()
    {
        return $this->hasOne(Drone::class);
    }

    public function company()
    {
      return $this->belongsTo(Company::class);
    }

    public function hasPosition()
    {
      return $this->hasOne(PositionUser::class);
    }
}
