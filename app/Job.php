<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
   public $timestamps = false;
     public function worker()
    {
    	# code...
    	return $this->hasOne('App\Worker');
    }
}
