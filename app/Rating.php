<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $dates = ['created_at'];
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
    public function user() {
    return $this->belongsTo(User::class);
}

	public function worker() {
	    return $this->belongsTo(Worker::class, 'worker_id', 'user_id');
	}

}
