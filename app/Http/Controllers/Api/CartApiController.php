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
use Illuminate\Support\Facades\DB;

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

          //get cart item count
          $cart_item_count = Utility::getCartItemCount($params->add_to_cart->retailer_id);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
              $returnedObj['aceplusStatusCode']     = $result['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $result['aceplusStatusMessage'];
              $returnedObj['cart_item_count']       = $cart_item_count;
              return \Response::json($returnedObj);
          }
          else{
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
            $returnedObj['cart_item_count']       = $cart_item_count;
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

          $retailer_id    = $params->clear_cart_list->retailer_id;
          $retailshop_id  = $params->clear_cart_list->retailshop_id;

          // $result = $this->repo->clearCartItems($params->clear_cart_list);
          $result = $this->repo->clearCartItems($retailer_id,$retailshop_id);

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
          DB::beginTransaction();

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

            if(isset($cart_items_result["cart_items"]) && count($cart_items_result["cart_items"]) > 0){
              $cart_items = $cart_items_result["cart_items"];
            }
            else{
              $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage']  = "Cart is empty!";
              return \Response::json($returnedObj);
            }

            //start invoice
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

            $today = date('Y-m-d');  //get today date
            $current_timestamp = date('Y-m-d H:i:s');  //get current timestamp

            $tax_rate = $configRepo->getTaxPercentage();

            //start total net amt
            $total_net_amt = 0.0;

            //array to store invoice_details
            $invoice_detail_array = array();

            foreach($cart_items as $cart_item){
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

              //start calculating total net amount
              $net_amt = $product_detail->price * $cart_item->quantity;
              $total_net_amt += $net_amt;
              //end calculating total net amount

              //start invoice detail
              $product_id       = $product_detail->id;
              $product_group_id = $product_detail->product_group_id;
              $uom_id           = $product_detail->product_uom_type_id;
              $status           = StatusConstance::status_confirm_value;
              $uom              = $product_detail->product_uom_type_name_eng;
              $quantity         = $cart_item->quantity;
              $unit_price       = $product_detail->price;
              $net_amt          = $net_amt;
              $discount_amt     = 0.0;  //currently, there is no discount amount
              $net_amt_w_disc   = $net_amt - $discount_amt;
              $tax_amt          = Utility::calculateTaxAmount($net_amt_w_disc);
              $payable_amt      = $net_amt_w_disc + $tax_amt;
              $remark           = "";
              $confirm_by       = NULL;
              $confirm_date     = NULL;
              $cancel_by        = NULL;
              $cancel_date      = NULL;

              //create invoice detail obj
              $invoiceDetailObj = new InvoiceDetail();

              $invoiceDetailObj->product_id = $product_id;
              $invoiceDetailObj->product_group_id = $product_group_id ;
              $invoiceDetailObj->uom_id = $uom_id;
              $invoiceDetailObj->status = $status;
              $invoiceDetailObj->uom = $uom;
              $invoiceDetailObj->quantity = $quantity;
              $invoiceDetailObj->unit_price = $unit_price;
              $invoiceDetailObj->net_amt = $net_amt;
              $invoiceDetailObj->discount_amt = $discount_amt;
              $invoiceDetailObj->net_amt_w_disc = $net_amt_w_disc;
              $invoiceDetailObj->tax_amt = $tax_amt;
              $invoiceDetailObj->payable_amt = $payable_amt;
              $invoiceDetailObj->remark = $remark;
              $invoiceDetailObj->confirm_by = $confirm_by;
              $invoiceDetailObj->confirm_date = $confirm_date;
              $invoiceDetailObj->cancel_by = $cancel_by;
              $invoiceDetailObj->cancel_date = $cancel_date;
              $invoiceDetailObj->created_by = $retailer_id;
              $invoiceDetailObj->updated_by = $retailer_id;
              $invoiceDetailObj->deleted_by = NULL;
              $invoiceDetailObj->created_at = $current_timestamp;
              $invoiceDetailObj->updated_at = $current_timestamp;
              $invoiceDetailObj->deleted_at = NULL;
              //end invoice detail

              array_push($invoice_detail_array,$invoiceDetailObj);
            }

            //declare repositories
            $invoiceApiRepo = new InvoiceApiRepository();

            //amounts
            $total_discount_amt = 0.0;
            $total_net_amt_w_disc = $total_net_amt - $total_discount_amt;
            $total_tax_amt = Utility::calculateTaxAmount($total_net_amt_w_disc);
            $total_payable_amt = $total_net_amt_w_disc + $total_tax_amt;

            //create invoice obj
            $invoiceObj = new Invoice();
            // $invoiceObj->id                   = $invoice_id;
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

            $invoice_header_result            = $invoiceApiRepo->saveInvoice($invoiceObj,$invoice_id);

            if($invoice_header_result["aceplusStatusCode"] !== ReturnMessage::OK){
              DB::rollback();
              $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
              $returnedObj['aceplusStatusMessage'] = $invoice_header_result["aceplusStatusMessage"];
              $returnedObj['data'] = [];
            }
            //invoice header is successfully saved
            //end invoice header

            //start invoice_detail
            //start requirements to generate invoice_detail_id
            $invoice_detail_table           = (new InvoiceDetail())->getTable();
            $invoice_detail_col             = 'id';
            $invoie_detail_offset           = 1;
            $invoice_detail_pad_length      = $configRepo->getInvoiceDetailIdPadLength()[0]->value; //number of digits without prefix and date
            //end requirements to generate invoice_detail_id

            //start requirements to generate invoice_detail_history_id
            $invoice_detail_history_table      = (new InvoiceDetailHistory())->getTable();
            $invoice_detail_history_col        = 'id';
            $invoie_detail_history_offset      = 1;
            $invoice_detail_history_pad_length = $configRepo->getInvoiceDetailIdPadLength()[0]->value; //number of digits without prefix and date
            //end requirements to generate invoice_detail_history_id

            foreach ($invoice_detail_array as $invoice_detail) {
              //generate invoice_detail_id start
              $detail_id                      = Utility::generate_id($invoice_id,$invoice_detail_table,$invoice_detail_col,$invoie_detail_offset,$invoice_detail_pad_length);
              //generate invoice_detail_id end
              //save each invoice detail
              $invoice_detail_result = $invoiceApiRepo->saveInvoiceDetail($invoice_detail,$detail_id,$invoice_id);

              if($invoice_detail_result["aceplusStatusCode"] !== ReturnMessage::OK){
                DB::rollback();
                $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                $returnedObj['aceplusStatusMessage'] = $invoice_detail_result["aceplusStatusMessage"];
                $returnedObj['data'] = [];
              }
              //invoice_detail is successfully saved

              //start invoice_detail_history
              //start generating invoice_detail_history_id
              $detail_history_id                 = Utility::generate_id($detail_id,$invoice_detail_history_table,$invoice_detail_history_col,$invoie_detail_history_offset,$invoice_detail_history_pad_length);
              //end generating invoice_detail_history_id

              $invDetailHistoryObj = new InvoiceDetailHistory();
              $invDetailHistoryObj->id                = $detail_history_id;
              $invDetailHistoryObj->invoice_detail_id = $detail_id;
              $invDetailHistoryObj->qty               = $invoice_detail->quantity;
              $invDetailHistoryObj->date              = date('Y-m-d H:i:s');
              $invDetailHistoryObj->type              = CoreConstance::invoice_detail_order_value; //invoice_history_type is "order"
              $invDetailHistoryObj->status            = 1; //default is active

              $invoice_detail_history_result          = $invoiceApiRepo->saveInvoiceDetailHistory($invDetailHistoryObj);

              if($invoice_detail_history_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                $returnedObj['aceplusStatusCode']     = $invoice_detail_history_result['aceplusStatusCode'];
                $returnedObj['aceplusStatusMessage']  = $invoice_detail_history_result['aceplusStatusMessage'];
                return $returnedObj;
              }
              //end invoice_detail_history
            }
            //end invoice_detail
            //end invoice

            //after saving invoice successfully, cart needs to be cleared
            //start cart clear
            $cart_clear_result = $this->repo->clearCartItems($retailer_id,$retailshop_id);

            if($cart_clear_result["aceplusStatusCode"] !== ReturnMessage::OK){
              DB::rollback();
              $returnedObj['aceplusStatusCode']     = ReturnMessage::INTERNAL_SERVER_ERROR;
              $returnedObj['aceplusStatusMessage']  = $cart_clear_result["aceplusStatusMessage"];
            }
            //end cart clear

            DB::commit();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['aceplusStatusMessage'] = "Cart is successfully checked out!";
            $returnedObj['data'] = [];
            return \Response::json($returnedObj);
          }
          //API parameter is missing
          else{
            DB::rollback();
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
            $returnedObj['data'] = [];
            return \Response::json($returnedObj);
          }
      }
      catch(\Exception $e){
        DB::rollback();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
        return $returnedObj;
      }
    }
    else{
      return \Response::json($checkServerStatusArray);
    }
  }

  public function downloadOrderList(){
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
              dd('cart_items',$cart_items);
              // $returnedObj['data']['cart_list']             = $cart_items;
              $returnedObj['data'][0]["cart_list"]             = $cart_items;
              $returnedObj['data'][0]['total_payable_amount']  = $whole_order_payable_amount;


              $returnedObj['aceplusStatusCode']     = $result['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $result['aceplusStatusMessage'];
              // dd('returnObj',$returnedObj);
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
}
