<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-24
 * Time: 10:56 AM
 */

namespace App\Backend\CorePermissionRole;

use Illuminate\Database\Eloquent\Model;

class CorePermissionRole extends Model
{
    protected $table = 'core_permission_role';

    protected $casts = [
       'id' => 'integer',
       'role_id' => 'integer',
       'permission_id' => 'integer',
       'position' => 'integer',
       'created_by' => 'integer',
       'updated_by' => 'integer',
       'deleted_by' => 'integer',
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
       'deleted_at' => 'datetime'
   ];

    protected $fillable = [
        'id',
        'role_id',
        'permission_id',
        'position',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];
}
