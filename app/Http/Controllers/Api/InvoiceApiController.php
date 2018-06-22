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
use App\Core\Utility;
use App\Api\ShopList\ShopListApiRepository;
use App\Api\Product\ProductApiRepository;

class InvoiceApiController extends Controller
{
  public function __construct(InvoiceApiRepositoryInterface $repo)
  {
      $this->repo = $repo;
  }

  public function upload(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data'] = [];
        if (isset($params->invoices) && count($params->invoices) > 0) {

          $result = $this->repo->uploadInvoice($params->invoices);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
              $returnedObj['aceplusStatusCode'] = $result['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage'] = "Success!";
              if(isset($result['invoice_id']) && $result['invoice_id'] !== null && $result['invoice_id'] !== ""){
                $returnedObj['invoice_id'] = $result['invoice_id'];
              }
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

  public function getInvoiceList(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data']= [];
        if (isset($params->invoice_list) && count($params->invoice_list) > 0) {

          $retailer_id  = $params->invoice_list->retailer_id;
          $filter       = $params->invoice_list->filter;

          $result = $this->repo->getInvoiceList($retailer_id,$filter);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
              $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage']  = "Success!";
              if(isset($result['invoices']) && count($result['invoices']) > 0){
                $returnedObj['data']                  = $result['invoices'];
              }
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

  public function getInvoiceDetail(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];

        $shopListApiRepo  = new ShopListApiRepository();
        $productApiRepo   = new ProductApiRepository();

        $returnedObj['data']= [];
        if (isset($params->invoice_detail) && count($params->invoice_detail) > 0) {
          $invoice_id  = $params->invoice_detail->invoice_id;

          $result = $this->repo->getInvoiceDetail($invoice_id);

          //if invoice_detail result fails, return with error
          if($result['aceplusStatusCode'] !== ReturnMessage::OK) {
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
            return \Response::json($returnedObj);
          }

          //start gift products
          $invoice_promotions = $this->repo->getInvoicePromotionsByInvoiceId($invoice_id);

          //declare invoice detail array and index
          $gift_array = array();
          $gift_index = 0;

          //construct array
          foreach($invoice_promotions as $invoice_promotion){
            $promotion_item_level_id = $invoice_promotion->promotion_item_level_id;
            $promotion_product_id = $invoice_promotion->product_id;
            $promotion_qty = $invoice_promotion->qty;

            //get retailshop ward id
            $retailshop_id = $result['invoices']->retailshop_id;
            $retailshop_obj = $shopListApiRepo->getShopById($retailshop_id);
            $retailshop_address_ward_id = $retailshop_obj->address_ward_id;

            //get gift product detail
            $gift_product_detail_result = $productApiRepo->getProductDetailByID($promotion_product_id, $retailshop_address_ward_id);

            //if getting promotion product detail fails
            if($gift_product_detail_result['aceplusStatusCode'] !== ReturnMessage::OK) {
              $returnedObj['aceplusStatusCode']     = $gift_product_detail_result['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $gift_product_detail_result['aceplusStatusMessage'];
              return \Response::json($returnedObj);
            }

            //get details
            $gift_product_detail = $gift_product_detail_result['resultObj'];

            $gift_array[$gift_index]['invoice_id']                = $invoice_promotion->invoice_id;
            $gift_array[$gift_index]['product_id']                = $promotion_product_id;
            $gift_array[$gift_index]['product_group_id']          = $gift_product_detail->product_group_id;
            $gift_array[$gift_index]['uom_id']                    = $gift_product_detail->product_uom_type_id;
            $gift_array[$gift_index]['status']                    = null;
            $gift_array[$gift_index]['uom']                       = $gift_product_detail->product_uom_type_name_eng;
            $gift_array[$gift_index]['quantity']                  = $promotion_qty;
            $gift_array[$gift_index]['unit_price']                = 0.0;
            $gift_array[$gift_index]['net_amt']                   = 0.0;
            $gift_array[$gift_index]['discount_amt']              = 0.0;
            $gift_array[$gift_index]['net_amt_w_disc']            = 0.0;
            $gift_array[$gift_index]['payable_amt']               = 0.0;
            $gift_array[$gift_index]['confirm_date']              = null;
            $gift_array[$gift_index]['cancel_by']                 = null;
            $gift_array[$gift_index]['cancel_date']               = null;
            $gift_array[$gift_index]['created_by']                = null;
            $gift_array[$gift_index]['updated_by']                = null;
            $gift_array[$gift_index]['product_name']              = $gift_product_detail->name;
            $gift_array[$gift_index]['product_uom_type_name_eng'] = $gift_product_detail->product_uom_type_name_eng;
            $gift_array[$gift_index]['product_uom_type_name_mm']  = $gift_product_detail->product_uom_type_name_mm;
            $gift_array[$gift_index]['total_uom_quantity']        = $gift_product_detail->total_uom_quantity;
            $gift_array[$gift_index]['product_volume_type_name']  = $gift_product_detail->product_volume_type_name;
            $gift_array[$gift_index]['product_container_type_name'] = $gift_product_detail->product_container_type_name;
            $gift_array[$gift_index]['status_text']               = null;
            $gift_index++;
            // array_push($result['invoices']->invoice_detail,$gift_array[$gift_index]);
          }
          //end gift products

          $total_product_array = array_merge($result['invoices']->invoice_detail,$gift_array);

          $result['invoices']->invoice_detail = $total_product_array;

          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Success!";
          $returnedObj['data']                  = $result['invoices'];
          return \Response::json($returnedObj);

          // else{
          //   $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
          //   $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
          //   return \Response::json($returnedObj);
          // }
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
