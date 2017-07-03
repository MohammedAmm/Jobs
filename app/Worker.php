<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    //
    protected $primaryKey ='user_id';
    protected $fillable = [
     'job_id','avatar','age','phone','address_id','wage','rate','no_rates'];
    
     public function user()
    {
        # code...
        return $this->belongsTo('App\User');

    }
      public function address()
    {
        # code...
        return $this->belongsTo('App\Address');
    }
      public function job()
    {
        # code...
        return $this->belongsTo('App\Job');
    }
    public function ratings()
    {
        # code...
        return $this->hasMany(Rating::class, 'worker_id', 'user_id');
    }
    public function averageRating() {
        return $this->hasMany(Rating::class, 'worker_id', 'user_id')->avg('ratings');
    }

    public function totalRatings() {
        return $this->hasMany(Rating::class, 'worker_id', 'user_id')->count();
    }
    
}
