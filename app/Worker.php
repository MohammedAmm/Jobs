<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    //
    protected $primaryKey ='user_id';
    protected $fillable = [
     'job_id','avatar','phone','address_id','wage'    ];
    
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

    public function averageRating() {
        return $this->hasMany(Rating::class, 'worker_id', 'user_id')->avg('ratings');
    }

    public function totalRatings() {
        return $this->hasMany(Rating::class, 'worker_id', 'user_id')->count();
    }
    
}
