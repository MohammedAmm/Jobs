<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
     public function worker()
    {
    	# code...
    	return $this->hasOne('App\Worker');
    }
}
