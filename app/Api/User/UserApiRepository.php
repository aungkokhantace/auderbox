<?php
namespace App\Api\User;
use App\User;
use App\Api\User\UserApiRepositoryInterface;
use App\Core\ReturnMessage;
use App\Core\User\UserRepository;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-04
 * Time: 11:41 AM
 */

class UserApiRepository implements UserApiRepositoryInterface
{
    public function getUserByPhoneNo($phone_no) {
        $result     = User::where('phone_no',$phone_no)
                        ->where('status',1)
                        ->whereNull('deleted_at')
                        ->first();
        return $result;
    }
}
