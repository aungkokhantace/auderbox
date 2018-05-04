<?php
namespace App\Api\User;
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-04
 * Time: 11:41 AM
 */
interface UserApiRepositoryInterface
{
    public function getUserByPhoneNo($phone_no);
}
