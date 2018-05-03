<?php namespace App\Core\User;

/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 5/21/2016
 * Time: 3:51 PM
 */
interface UserRepositoryInterface
{
    public function getUsers();
    public function getObjByID($id);
    public function create($paramObj);
    public function update($paramObj);
    public function delete_users($id);
    public function getRoles();
    public function changeDisableToEnable($id,$cur);
    public function changeEnableToDisable($id);

}