<?php
namespace App\Api\Point;

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
use App\Core\CoreConstance;
use App\Backend\InvoiceSession\InvoiceSession;
use App\Api\Product\ProductApiRepository;
use App\Api\ShopList\ShopListApiRepository;
use App\Backend\Point\RetailerPoint;

/**
 * Author: Aung Ko Khant
 * Date: 2018-06-20
 * Time: 05:26 PM
 */

class PointApiRepository implements PointApiRepositoryInterface
{
  public function getRetailerTotalPoint($retailer_id, $retailshop_id) {
    $returnedObj = array();
    $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

    try{
      $result = RetailerPoint::where('retailer_id',$retailer_id)
                              ->where('retailshop_id',$retailshop_id)
                              ->sum('available_points');

      $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
      $returnedObj['aceplusStatusMessage']  = "Point is successfully downloaded!";
      $returnedObj['retailer_total_points'] = $result;

      return $returnedObj;
    }
    catch(\Exception $e){
      DB::rollback();
      $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
      return $returnedObj;
    }
  }
}
