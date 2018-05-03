<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:24 PM
 */

namespace App\Core\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\Utility;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function getPermissions()
    {
        $roles = Permission::whereNull('deleted_at')->get();
        return $roles;
    }

    public function create($paramObj)
    {
        $tempObj = Utility::addCreatedBy($paramObj);
        $tempObj->save();
    }

    public function update($paramObj)
    {
        $tempObj = Utility::addUpdatedBy($paramObj);
        $tempObj->save();
    }

    public function delete($id)
    {
        if($id != 1){

            $tempObj = Permission::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();
        }
    }

    public function getObjByID($id){
        $role = Permission::find($id);
        return $role;
    }

    public static function getPermissionsByRoleId($roleId){

        $permissionIds = DB::table('core_permission_role')
            ->where('role_id', '=', $roleId)
            ->whereNull('deleted_at')
            ->get();

        $result = array();

        if (count($permissionIds) > 0) {

            $countPermission = 0;

            foreach($permissionIds as $id){

                $permission = Permission::where('id', '=' ,$id->permission_id)
                    ->whereNull('deleted_at')->first()->toArray();

                $result[$countPermission] = $permission;
                $countPermission++;
            }

            return $result;
        }
        else{
            return null;
        }

    }
}