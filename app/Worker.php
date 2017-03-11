<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    //
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
}
