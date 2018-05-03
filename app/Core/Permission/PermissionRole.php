<?php namespace App\Core\Permission;
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/27/2016
 * Time: 5:07 PM
 */
use Eloquent;

class PermissionRole extends Eloquent {

    protected $table = 'core_permission_role'; //manual assign the table this model is associated with. usually no need if the model name is the singular of the table name.
    protected $softDelete = true; //enabled the softdelete, meaning record wont be deleted instead 'delete_at' timestamp will be set.

    #protected guarded = []; //this is another way of protecting mass assignment, other than column u specify here, all will be able to mass assigned
    protected $fillable = []; // u can mass assign columns that is specified here.

    public function role()
    {
        return $this->belongsTo('App\Core\Role\Role', 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsTo('App\Core\Permission\Permission', 'permission_id', 'id');
    }



}