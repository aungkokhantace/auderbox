<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:22 PM
 */
namespace App\Core\Permission;

interface PermissionRepositoryInterface
{
    public function getPermissions();
    public function create($paramObj);
    public function update($paramObj);
    public function getObjByID($id);
    public function delete($id);
}
