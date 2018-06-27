<?php
namespace App\Api\ShopList;
use App\User;
use App\Api\User\UserApiRepositoryInterface;
use App\Core\ReturnMessage;
use App\Core\User\UserRepository;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\Retailshop\Retailshop;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-04
 * Time: 11:41 AM
 */

class ShopListApiRepository implements ShopListApiRepositoryInterface
{
    public function getShopsByRetailerId($retailer_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $retail_shops = Retailshop::select('id', 'retailer_id', 'name_eng', 'name_mm', 'phone', 'address', 'registration_no')
                              ->where('retailer_id',$retailer_id)
                              ->whereNull('deleted_at')
                              ->where('status',1)
                              ->get();


        if(isset($retail_shops) && count($retail_shops)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['resultObjs']            = $retail_shops;
          return $returnedObj;
        }
        else{
          //if retailshops do not exist
          $returnedObj['aceplusStatusMessage']  = "Retailshops do not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }

    public function getShopById($id){
      $retailshop = Retailshop::find($id);
      return $retailshop;
    }

    public function saveSelectedShop($retailer_id,$retailshop_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        DB::beginTransaction();
        //get current timestamp
        $current_timestamp = date('Y-m-d H:i:s');

        //clear old data
        DB::table('retailer_session')
                ->where('retailer_id',$retailer_id)
                // ->where('retailshop_id',$retailshop_id)
                ->delete();

        $result = DB::table('retailer_session')->insert([
          'retailer_id'          => $retailer_id,
          'retailshop_id'        => $retailshop_id,
          'selected_datetime'    => $current_timestamp
        ]);

        if($result){
          DB::commit();
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          return $returnedObj;
        }
        else{
          DB::rollback();
          //if retailshops do not exist
          $returnedObj['aceplusStatusMessage']  = "Saving selected retailshop_id failed!";
          return $returnedObj;
        }
      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
