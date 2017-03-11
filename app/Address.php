<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    public function worker()
    {
    	# code...
    	return $this->belongsTo('App\Worker');
    }
}
