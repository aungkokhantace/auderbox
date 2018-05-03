<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 3/21/2016
 * Time: 4:24 PM
 */

namespace App\Core\Role;


interface RoleRepositoryInterface
{
    public function getRoles();
    public function create($paramObj);
    public function update($paramObj);
    public function getObjByID($id);
    public function delete($id);
    public function check_staff($id);
    public function getRolePermissions($id);
}