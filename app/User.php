<?php

namespace
 App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Rating;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_token','name', 'email','role_id','password','admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role()
    {
        # code...
        return $this->belongsTo('App\Role');

    }
    public function worker()
    {
        # code...
        return $this->hasOne('App\Worker');
    }

    public function sentRates() {
        return $this->hasMany(Rating::class);
    }
}
