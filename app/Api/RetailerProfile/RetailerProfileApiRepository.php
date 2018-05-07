<?php
namespace App\Api\RetailerProfile;
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

class RetailerProfileApiRepository implements RetailerProfileApiRepositoryInterface
{
    public function getUserById($id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $user = User::find($id);
        if(isset($user) && count($user)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['userObj']               = $user;
          return $returnedObj;
        }
        else{
          //if user does not exist
          $returnedObj['aceplusStatusMessage']  = "User does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
