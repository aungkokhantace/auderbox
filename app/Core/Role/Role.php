<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Core\Role;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'core_roles';

    protected $fillable = [
        'id',
        'name',
        'description','updated_at','created_at','deleted_at'

    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function permissions()
    {
        return $this->belongsTo('App\Core\Permission\Permission');
    }
}
