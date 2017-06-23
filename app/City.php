<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    public $timestamps=false;
    public function addresses(){
        return $this->hasMany('App\Address');
    }
}
