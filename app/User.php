<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="core_users";
    protected $fillable = [
        'id','user_name','email','display_name','password','role_id','status','updated_at','created_at','deleted_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getObjByID(){
        return $this->id;
    }
    public function role()
    {
        return $this->belongsTo('App\Core\Role\Role','role_id','id');
    }
    public function session(){
        return $this->hasMany('App\Session\Session');
    }
}
