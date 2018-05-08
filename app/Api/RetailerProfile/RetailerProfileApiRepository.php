<?php
namespace App\Api\RetailerProfile;
use App\User;
use App\Api\User\UserApiRepositoryInterface;
use App\Core\ReturnMessage;
use App\Core\User\UserRepository;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\Retailer\Retailer;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-04
 * Time: 11:41 AM
 */

class RetailerProfileApiRepository implements RetailerProfileApiRepositoryInterface
{
    public function getRetailerById($user_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $retailer = Retailer::select('id', 'user_id', 'name_eng', 'name_mm', 'nrc', 'dob', 'phone', 'address', 'photo')
                              ->where('user_id',$user_id)
                              ->whereNull('deleted_at')
                              ->where('status',1)
                              ->first();

        if(isset($retailer) && count($retailer)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['resultObj']             = $retailer;
          return $returnedObj;
        }
        else{
          //if user does not exist
          $returnedObj['aceplusStatusMessage']  = "Retailer does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
