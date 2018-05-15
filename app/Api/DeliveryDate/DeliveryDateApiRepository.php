<?php
namespace App\Api\DeliveryDate;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-15
 * Time: 11:44 AM
 */

class DeliveryDateApiRepository implements DeliveryDateApiRepositoryInterface
{
    public function calculateDeliveryDate($brand_owner_id, $retailshop_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        //get current date for now (temporarily)
        $delivery_date = date('Y-m-d');

        if(isset($delivery_date) && count($delivery_date)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['resultObj']             = $delivery_date;
          return $returnedObj;
        }
        else{
          //if date does not exist
          $returnedObj['aceplusStatusMessage']  = "Delivery Date does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
