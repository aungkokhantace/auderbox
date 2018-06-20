<?php
namespace App\Backend\Point;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\Invoice\Invoice;
use App\Backend\InvoiceDetail\InvoiceDetail;
use App\Backend\InvoiceDetailHistory\InvoiceDetailHistory;
use App\Core\StatusConstance;
use App\Core\Config\ConfigRepository;
use Carbon\Carbon;
use App\Backend\Retailshop\Retailshop;
use Auth;
use App\Log\LogCustom;
use App\Core\CoreConstance;


/**
 * Author: Aung Ko Khant
 * Date: 2018-06-19
 * Time: 05:06 PM
 */

class PointRepository implements PointRepositoryInterface
{
  public function getPromotionPoint(){
    $result = DB::table('promotion_points')
                    ->where('status','=',1) //get only one active record
                    ->first();
    return $result;
  }

  public function saveRetailerPoints($paramObj) {
    $returnedObj = array();
    $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

    $currentUser = Utility::getCurrentUserID(); //get currently logged in user

    try {
      DB::beginTransaction();

      $tempObj = Utility::addCreatedBy($paramObj);
      $tempObj->save();

      DB::commit();

      //create info log
      $date = $tempObj->updated_at;
      $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' added retailer_point_id = '.$tempObj->id . PHP_EOL;
      LogCustom::create($date,$message);

      $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
      $returnedObj['aceplusStatusMessage'] = "Retailer point is saved !";
      return $returnedObj;
    }
    catch(\Exception $e){
      DB::rollBack();
      //create error log
      $date    = date("Y-m-d H:i:s");
      $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' added a retailer point and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
      LogCustom::create($date,$message);

      $returnedObj['aceplusStatusMessage'] = $e->getMessage();
      return $returnedObj;
    }
  }

  public function saveRetailerPointLog($paramObj) {
    $returnedObj = array();
    $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

    $currentUser = Utility::getCurrentUserID(); //get currently logged in user

    try {
      DB::beginTransaction();
      
      $tempObj = Utility::addCreatedBy($paramObj);
      $tempObj->save();

      DB::commit();

      //create info log
      $date = $tempObj->updated_at;
      $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' added retailer_point_log_id = '.$tempObj->id . PHP_EOL;
      LogCustom::create($date,$message);

      $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
      $returnedObj['aceplusStatusMessage'] = "Retailer point is saved !";
      return $returnedObj;
    }
    catch(\Exception $e){
      DB::rollBack();
      //create error log
      $date    = date("Y-m-d H:i:s");
      $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' added a retailer point log and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
      LogCustom::create($date,$message);

      $returnedObj['aceplusStatusMessage'] = $e->getMessage();
      return $returnedObj;
    }
  }
}
