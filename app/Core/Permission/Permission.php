<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Core\Permission;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'core_permissions';

    protected $fillable = [
        'id',
        'module',
        'name',
        'description',
        'url','updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
,
    ];

}
