<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 20/06/2016
 * Time: 4:26 PM
 */

namespace App\Core\Role;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\Permission\Permission;
use App\Core\Permission\PermissionRole;
use App\Core\Utility;

class RoleRepository implements RoleRepositoryInterface
{
    public function getRoles()
    {
        $roles = Role::whereNull('deleted_at')->get();
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

    public function getObjByID($id){
        $role = Role::find($id);
        return $role;
    }

    public function delete($id){
        if($id != 1){

            $roleObj = Role::find($id);
            $roleObj = Utility::addDeletedBy($roleObj);
            $roleObj->deleted_at = date('Y-m-d H:m:i');
            $roleObj->save();
        }
    }

    public function check_staff($id){
        $subcategory = DB::table('core_roles')->where('role_id', '=', $id)->first();//check whether there are users of this user_type
        return $subcategory;
    }

    public function getRolePermissions ($role_id)
    {

        $result = [];

        $rel = DB::select("SELECT distinct module FROM core_permissions ");
        $features = json_decode(json_encode($rel), true);
        foreach ($features as $feature)
        {
            $permissions = [];
            $feature_permissions = Permission::where('module', $feature['module'])->get();

            foreach($feature_permissions as $fp)
            {
                $pivot = PermissionRole::whereNull('deleted_at')->where('role_id', $role_id)->where('permission_id', $fp->id)->first();
                $checked = ( count( $pivot ) > 0 ) ? true : false;

                $permissions [] = [
                    'id' =>$fp->id,
                    'feature_id'=>$fp->feature_id,
                    'name'=>$fp->name,
                    'descr'=>$fp->descr,
                    'module'=>$fp->module,
                    'position'=>$fp->position,
                    'url'=>$fp->url,
                    'checked'=>$checked
                ];
            }


            $result [] = [
                'feature'=>$feature,
                'permissions'=>$permissions
            ];
        }

        // get result ...
        return $result;
    }

    public function getPermissionsByRoleId($rId)
    {
        $array = [];
        try {
            $tb = (new PermissionRole())->getTable();
            $result = DB::select("SELECT * FROM $tb
                                    WHERE role_id = '$rId'
                                ");

            if (isset($result) && count($result) > 0) {
                return $result;
            } else {
                return $array;
            }
        } catch (Exception $ex) {
            return $array;
        }

    }

    public function getPermissionsRoleByRoleIdNPermissionId($rId,$pId){
        $array = [];
        try{
            $tb = (new PermissionRole())->getTable();
            $result = DB::select("SELECT * FROM $tb
                                WHERE role_id = '$rId'
                                AND permission_id = '$pId'
                            ");

            if(isset($result) && count($result)>0) {
                return $result;
            }
            else {
                return $array;
            }
        }
        catch(Exception $ex){
            return $array;
        }

    }

    public function updatePermissionsRoleByRoleIdNPermissionId($rId,$pId){

        try{
            $tb = (new PermissionRole())->getTable();
            $result =  DB::table($tb)
                ->where('role_id', $rId)
                ->where('permission_id', $pId)
                ->update(array('deleted_at' => null));

            if($result) {
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $ex){
            return false;
        }

    }

}