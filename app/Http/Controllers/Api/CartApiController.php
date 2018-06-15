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
use App\Api\Cart\CartApiRepositoryInterface;
use App\Api\Cart\CartApiRepository;
use App\Api\Product\ProductApiRepository;
use App\Api\ShopList\ShopListApiRepository;
use App\Backend\Invoice\Invoice;
use App\Backend\InvoiceDetail\InvoiceDetail;
use App\Backend\InvoiceDetailHistory\InvoiceDetailHistory;
use App\Core\Config\ConfigRepository;
use App\Core\StatusConstance;

class CartApiController extends Controller
{
  public function __construct(CartApiRepositoryInterface $repo)
  {
      $this->repo = $repo;
  }

  public function addToCart(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data'] = [];
        if (isset($params->add_to_cart) && count($params->add_to_cart) > 0) {
          $result = $this->repo->addToCart($params->add_to_cart);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
            //get cart item count
            $cart_item_count = Utility::getCartItemCount($params->add_to_cart->retailer_id);

            $returnedObj['aceplusStatusCode']     = $result['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage']  = $result['aceplusStatusMessage'];
            $returnedObj['cart_item_count']       = $cart_item_count;
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

  public function updateCartQty(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data'] = [];
        if (isset($params->add_to_cart) && count($params->add_to_cart) > 0) {

          $result = $this->repo->updateCartQty($params->add_to_cart);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
              $returnedObj['aceplusStatusCode'] = $result['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
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

  public function downloadCartList() {
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){

        $productApiRepo     = new ProductApiRepository();
        $retailshopApiRepo  = new ShopListApiRepository();

        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data'] = [];
        if (isset($params->cart_list) && count($params->cart_list) > 0) {
          $result = $this->repo->getCartItems($params->cart_list);

          //result is ok and cart has items
          if($result['aceplusStatusCode'] == ReturnMessage::OK && isset($result['cart_items']) && count($result['cart_items']) > 0){
            //total payable amount for whole order
            $whole_order_payable_amount = 0;

            $cart_items = $result['cart_items'];

            //get details of cart_items
            foreach($cart_items as $raw_cart_item){
              //define maximum qty of product (50 for now //hard code)
              $raw_cart_item->maximum_qty = 50;

              $product_id = $raw_cart_item->product_id;
              $product_qty = $raw_cart_item->quantity;
              $retailshop_id = $raw_cart_item->retailshop_id;
              //get retailshop object
              $retailshop = $retailshopApiRepo->getShopById($retailshop_id);
              //get retailshop ward id
              $retailshop_address_ward_id = $retailshop->address_ward_id;

              // get product details
              $product_detail_result = $productApiRepo->getProductDetailByID($product_id, $retailshop_address_ward_id);

              if($product_detail_result['aceplusStatusCode'] !== ReturnMessage::OK) {
                $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                $returnedObj['aceplusStatusMessage'] = $product_detail_result['aceplusStatusMessage'];
                return \Response::json($returnedObj);
              }
              $product_detail = $product_detail_result['resultObj'];

              //bind to original cart object
              $raw_cart_item->product_name                = $product_detail->name;
              $raw_cart_item->product_uom_type_name_eng   = $product_detail->product_uom_type_name_eng;
              $raw_cart_item->product_uom_type_name_mm    = $product_detail->product_uom_type_name_mm;
              $raw_cart_item->product_volume_type_name    = $product_detail->product_volume_type_name;
              $raw_cart_item->product_container_type_name = $product_detail->product_container_type_name;
              $raw_cart_item->total_uom_quantity          = $product_detail->total_uom_quantity;
              $raw_cart_item->price                       = $product_detail->price;

              $payable_amount                             = $product_detail->price * $product_qty; //get total payable amount by multiplying unit_price and product_qty
              $tax_amount                                 = Utility::calculateTaxAmount($payable_amount);  //calculate tax amount
              $total_payable_amount                       = $payable_amount + $tax_amount; //get total payable amount including tax amount

              $raw_cart_item->payable_amount              = $total_payable_amount;

              //calculate final payable amount for the whole order
              $whole_order_payable_amount                 += $total_payable_amount;
            }
            $data = array();
            //response data array

            // $returnedObj['data']['cart_list']             = $cart_items;
            $returnedObj['data'][0]["cart_list"]                          = $cart_items;
            $returnedObj['data'][0]['total_payable_amount']  = $whole_order_payable_amount;


            $returnedObj['aceplusStatusCode']     = $result['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage']  = $result['aceplusStatusMessage'];

            return \Response::json($returnedObj);
          }
          //the cart is empty
          else if($result['aceplusStatusCode'] == ReturnMessage::OK) {
            $returnedObj['aceplusStatusCode'] = $result['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
            return \Response::json($returnedObj);
          }
          //error
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

  public function clearCartList() {
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){

        $productApiRepo     = new ProductApiRepository();
        $retailshopApiRepo  = new ShopListApiRepository();

        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data'] = [];
        if (isset($params->clear_cart_list) && count($params->clear_cart_list) > 0) {
          $result = $this->repo->clearCartItems($params->clear_cart_list);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
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

  public function checkoutCartList() {
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        try{
          $configRepo = new ConfigRepository();
          $productApiRepo     = new ProductApiRepository();
          $retailshopApiRepo  = new ShopListApiRepository();

          $params             = $checkServerStatusArray['data'][0];

          $returnedObj['data'] = [];
          if (isset($params->checkout_cart) && count($params->checkout_cart) > 0) {
            $retailer_id   = $params->checkout_cart->retailer_id;
            $retailshop_id = $params->checkout_cart->retailshop_id;
            $delivery_date = date('Y-m-d',strtotime($params->checkout_cart->delivery_date));

            //get cart items
            $cart_items_result = $this->repo->getCartItems($params->checkout_cart);

            if($cart_items_result['aceplusStatusCode'] !== ReturnMessage::OK){
              $returnedObj['aceplusStatusCode']     = ReturnMessage::INTERNAL_SERVER_ERROR;
              $returnedObj['aceplusStatusMessage']  = $cart_items_result['aceplusStatusMessage'];
              return \Response::json($returnedObj);
            }

            $cart_items = $cart_items_result["cart_items"];

            //start invoice
            $today = date('Y-m-d');  //get today date
            $current_timestamp = date('Y-m-d H:i:s');  //get current timestamp

            $tax_rate = $configRepo->getTaxPercentage();

            //start total net amt
            $total_net_amt = 0.0;
            foreach($cart_items as $cart_item){
              // dd('cart',$cart_item);
              //get retailshop object
              $retailshop = $retailshopApiRepo->getShopById($retailshop_id);

              //get retailshop ward id
              $retailshop_address_ward_id = $retailshop->address_ward_id;

              $product_detail_result = $productApiRepo->getProductDetailByID($cart_item->product_id, $retailshop_address_ward_id);

              if($product_detail_result['aceplusStatusCode'] !== ReturnMessage::OK){
                $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                $returnedObj['aceplusStatusMessage'] = "Product does not exist!";
                $returnedObj['data'] = [];
                return \Response::json($returnedObj);
              }

              $product_detail = $product_detail_result["resultObj"];

              $net_amt = $product_detail->price * $cart_item->quantity;
              $total_net_amt += $net_amt;
            }

            $total_discount_amt = 0.0;
            $total_net_amt_w_disc = $total_net_amt - $total_discount_amt;
            $total_tax_amt = Utility::calculateTaxAmount($total_net_amt_w_disc);
            $total_payable_amt = $total_net_amt_w_disc + $total_tax_amt;

            // dd('total_net_amt',$product_detail->price,$cart_item->quantity,$total_net_amt);
            //start invoice_id generation
            $id_prefix                      = $configRepo->getInvoicePrefixId()[0]->value;
            $date_str                       = date('Ymd',strtotime("now"));
            $prefix                         = $id_prefix.$date_str;
            $table                          = (new Invoice())->getTable();
            $col                            = 'id';
            $offset                         = 1;
            $pad_length                     = $configRepo->getInvoiceIdPadLength()[0]->value; //number of digits without prefix and date
            //generate invoice id
            $invoice_id                     = Utility::generate_id($prefix,$table,$col,$offset,$pad_length);
            //end invoice_id generation

            //create invoice obj
            $invoiceObj = new Invoice();
            $invoiceObj->id = $invoice_id;
            $invoiceObj->status               = StatusConstance::status_confirm_value;
            $invoiceObj->order_date           = $today;
            $invoiceObj->delivery_date        = $delivery_date;
            $invoiceObj->payment_date         = $delivery_date;
            $invoiceObj->retailer_id          = $retailer_id;
            $invoiceObj->brand_owner_id       = 1;              // currently
            $invoiceObj->retailshop_id        = $retailshop_id;
            $invoiceObj->tax_rate             = $tax_rate;
            $invoiceObj->total_net_amt        = $total_net_amt;
            $invoiceObj->total_discount_amt   = $total_discount_amt;
            $invoiceObj->total_net_amt_w_disc = $total_net_amt_w_disc;
            $invoiceObj->total_tax_amt        = $total_tax_amt;
            $invoiceObj->total_payable_amt    = $total_payable_amt;
            $invoiceObj->remark               = "";
            $invoiceObj->confirm_by           = NULL;
            $invoiceObj->confirm_date         = NULL;
            $invoiceObj->cancel_by            = NULL;
            $invoiceObj->cancel_date          = NULL;
            $invoiceObj->created_by           = $retailer_id;
            $invoiceObj->updated_by           = $retailer_id;
            $invoiceObj->deleted_by           = NULL;
            $invoiceObj->created_at           = $current_timestamp;
            $invoiceObj->updated_at           = $current_timestamp;
            $invoiceObj->deleted_at           = NULL;
            dd('obj',$invoiceObj);
            $invoiceRes                     = $this->saveInvoice($invoice,$invoice_id);
            //end invoice
          }
          //API parameter is missing
          else{
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
            $returnedObj['data'] = [];
            return \Response::json($returnedObj);
          }
      }
      catch(\Exception $e){
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
        return $returnedObj;
      }
    }
    else{
      return \Response::json($checkServerStatusArray);
    }
  }
}
