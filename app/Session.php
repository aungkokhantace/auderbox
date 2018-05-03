<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';
    protected $fillable=['user_id'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\Users','user_id','id');
    }

}
