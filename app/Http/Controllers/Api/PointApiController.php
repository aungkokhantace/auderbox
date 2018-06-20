<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Session;
use App\Core\Check;
use App\Core\Redirect\AceplusRedirect;
use Illuminate\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\Api\Invoice\InvoiceApiRepositoryInterface;
use App\Api\Invoice\InvoiceApiRepository;
use App\Core\Utility;
use App\Api\Cart\CartApiRepositoryInterface;
use App\Api\Cart\CartApiRepository;
use App\Api\Product\ProductApiRepository;
use App\Api\ShopList\ShopListApiRepository;
use App\Backend\Invoice\Invoice;
use App\Backend\InvoiceDetail\InvoiceDetail;
use App\Backend\InvoiceDetailHistory\InvoiceDetailHistory;
use App\Core\Config\ConfigRepository;
use App\Core\StatusConstance;
use App\Core\CoreConstance;
use App\Core\PromotionConstance;
use Illuminate\Support\Facades\DB;
use App\Api\Promotion\PromotionApiRepository;
use App\Api\Point\PointApiRepositoryInterface;
use App\Api\Point\PointApiRepository;

class PointApiController extends Controller
{
  public function __construct(PointApiRepositoryInterface $repo)
  {
      $this->repo = $repo;
  }

  public function getRetailerTotalPoints() {
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data'] = [];
        if (isset($params->retailer_total_points) && count($params->retailer_total_points) > 0) {
          // dd('$params->retailer_total_points',$params->retailer_total_points);
          $retailer_id    = $params->retailer_total_points->retailer_id;
          $retailshop_id  = $params->retailer_total_points->retailshop_id;

          $result = $this->repo->getRetailerTotalPoint($retailer_id,$retailshop_id);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
            //get cart item count
            // $cart_item_count = Utility::getCartItemCount($params->add_to_cart->retailer_id);

            $returnedObj['aceplusStatusCode']     = $result['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage']  = $result['aceplusStatusMessage'];
            $returnedObj['retailer_total_points'] = $result['retailer_total_points'];
            // $returnedObj['cart_item_count']       = $cart_item_count;
            return \Response::json($returnedObj);
          }
          else{
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
            return \Response::json($returnedObj);
          }
        }
        //API parameter is missing
        else{
          $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
          $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
          $returnedObj['data'] = [];
          return \Response::json($returnedObj);
        }
    }
    else{
        return \Response::json($checkServerStatusArray);
    }
  }
}
