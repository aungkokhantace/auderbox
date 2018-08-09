<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Core\StatusConstance;
use App\Backend\Invoice\Invoice;
use App\Backend\Invoice\InvoiceRepositoryInterface;
use App\Core\ReturnMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Core\FormatGenerator;
use App\Core\Utility;
use Maatwebsite\Excel\Facades\Excel;
use App\Core\Config\ConfigRepository;
use App\Backend\InvoiceDetailHistory\InvoiceDetailHistory;
use App\Core\CoreConstance;
use App\Backend\Point\PointRepository;
use App\Backend\Point\RetailerPoint;
use Illuminate\Support\Facades\DB;
use App\Log\LogCustom;
use App\Backend\RetailerPointLog\RetailerPointLog;
use App\Api\Product\ProductApiRepository;
use App\Api\ShopList\ShopListApiRepository;
use App\Api\Promotion\PromotionApiRepository;
use App\Backend\Product\ProductRepository;
use App\Backend\Retailshop\RetailshopRepository;
use App\Core\PromotionConstance;
use App\Backend\InvoicePromotion\InvoicePromotion;
use App\Api\Invoice\InvoiceApiRepository;

class InvoiceReportController extends Controller
{
  private $repo;

  public function __construct(InvoiceRepositoryInterface $repo)
  {
      $this->repo = $repo;
  }

  public function index() {
    if (Auth::guard('User')->check()) {
      //get invoices
      $invoices = $this->repo->getInvoiceList();

      if(isset($invoices) && count($invoices) > 0){
        foreach($invoices as $invoice_header){
          /* all status
          //get status text according to status (integer)
          if($invoice_header->status == StatusConstance::status_pending_value){
            $invoice_header->status_text = StatusConstance::status_pending_description;
          }
          else if($invoice_header->status == StatusConstance::status_confirm_value){
            $invoice_header->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_header->status == StatusConstance::status_deliver_value){
            $invoice_header->status_text = StatusConstance::status_deliver_description;
          }
          else if($invoice_header->status == StatusConstance::status_retailer_cancel_value){
            $invoice_header->status_text = StatusConstance::status_retailer_cancel_description;
          }
          else if($invoice_header->status == StatusConstance::status_brand_owner_cancel_value){
            $invoice_header->status_text = StatusConstance::status_brand_owner_cancel_description;
          }
          else{
            $invoice_header->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          */

          //for pilot version
          if($invoice_header->status == StatusConstance::status_confirm_value){
            $invoice_header->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_header->status == StatusConstance::status_deliver_value){
            $invoice_header->status_text = StatusConstance::status_deliver_description;
          }
          else if($invoice_header->status == StatusConstance::status_auderbox_cancel_value){
            $invoice_header->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          //for pilot version
          //end status text
        }
      }

      return view('report.invoice_report.index')
      ->with('invoices',$invoices);
    }
    else{
      return redirect('backend/unauthorize');
    }
  }

  public function invoiceDetail($invoice_id){
    if (Auth::guard('User')->check()) {
      //get invoice details
      $invoice = $this->repo->getInvoiceDetail($invoice_id);

      //start invoice promotion
      if(isset($invoice) && count($invoice)) {
        $promo_product_array = array();
        $productApiRepo     = new ProductApiRepository();
        $shopListApiRepo    = new ShopListApiRepository();

        $invoice_id = $invoice->id;
        $retailshop_id = $invoice->retailshop_id;
        //get retailshop object
        $retailshop = $shopListApiRepo->getShopById($retailshop_id);
        //get retailshop ward id
        $retailshop_address_ward_id = $retailshop->address_ward_id;

        //get invoice promotions by invoice_id
        $invoice_promotions = $this->repo->getInvoicePromotionsByInvoiceId($invoice_id);

        foreach($invoice_promotions as $invoice_promotion){
          $promo_product_id = $invoice_promotion->product_id;
          $promo_qty        = $invoice_promotion->qty;

          //get product detail including price
          $promo_product_detail_result = $productApiRepo->getProductDetailByID($promo_product_id,$retailshop_address_ward_id);

          if($promo_product_detail_result['aceplusStatusCode'] !== ReturnMessage::OK){
            $returnedObj['aceplusStatusCode']     = $promo_product_detail_result['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage']  = $promo_product_detail_result['aceplusStatusMessage'];
            return \Response::json($returnedObj);
          }
          $promo_product_detail               = $promo_product_detail_result['resultObj'];
          $promo_product_detail->quantity     = $promo_qty;
          $promo_product_detail->payable_amt  = 0.0;  //because this is present item
          $promo_product_detail->status_text  = "Gift Item";

          array_push($promo_product_array,$promo_product_detail);
        }
      }
      //end invoice promotion

      //start max order quantity from config
      $max_order_qty = Utility::getMaxOrderQty();
      //end max order quantity from config

      return view('report.invoice_report.invoice_detail')
          ->with('invoice',$invoice)
          ->with('promo_product_array',$promo_product_array)
          ->with('max_order_qty',$max_order_qty);
    }
    else{
      return redirect('backend/unauthorize');
    }
  }

  public function search($from_date = null, $to_date = null, $status = null) {
    if (Auth::guard('User')->check()) {
      //get invoices
      $invoices = $this->repo->getInvoiceList($from_date,$to_date,$status);

      if(isset($invoices) && count($invoices) > 0){
        foreach($invoices as $invoice_header){
          /*
          //all statuses
          //get status text according to status (integer)
          if($invoice_header->status == StatusConstance::status_pending_value){
            $invoice_header->status_text = StatusConstance::status_pending_description;
          }
          else if($invoice_header->status == StatusConstance::status_confirm_value){
            $invoice_header->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_header->status == StatusConstance::status_deliver_value){
            $invoice_header->status_text = StatusConstance::status_deliver_description;
          }
          else if($invoice_header->status == StatusConstance::status_retailer_cancel_value){
            $invoice_header->status_text = StatusConstance::status_retailer_cancel_description;
          }
          else if($invoice_header->status == StatusConstance::status_brand_owner_cancel_value){
            $invoice_header->status_text = StatusConstance::status_brand_owner_cancel_description;
          }
          else{
            $invoice_header->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          */

          //for pilot version
          if($invoice_header->status == StatusConstance::status_confirm_value){
            $invoice_header->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_header->status == StatusConstance::status_deliver_value){
            $invoice_header->status_text = StatusConstance::status_deliver_description;
          }
          else{
            $invoice_header->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          //for pilot version
          //end status text
        }

      }

      return view('report.invoice_report.index')
                ->with('invoices',$invoices)
                ->with('from_date', $from_date)
                ->with('to_date', $to_date)
                ->with('status', $status);
    }
    else{
      return redirect('backend/unauthorize');
    }
  }

  public function deliverInvoice(){
    $invoice_id = Input::get('delivered_invoice_id');
    $paramObj = $this->repo->getObjByID($invoice_id);
    try{
      DB::beginTransaction();
      //declare repo
      $pointRepo    = new PointRepository();
      $configRepo   = new ConfigRepository();

      //change to delivered status
      $paramObj->status = StatusConstance::status_deliver_value;

      $result = $this->repo->deliver($paramObj);

      if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
        //invoice and invoice_detail are delivered
        //start points
        //start retailer point
        $total_payable_amt = $paramObj->total_payable_amt;
        $today_date = date('Y-m-d');
        $current_timestamp = date('Y-m-d H:i:s');

        //get point configuration
        $points_config = $pointRepo->getPromotionPoint();

        if($points_config->with_expiration == 1){
          $life_time_day_count = $points_config->point_life_time_day_count;
          $promo_amount = $points_config->promo_amount;
          $promo_point = $points_config->promo_point;
        }
        else{
          $promo_amount = $points_config->promo_amount;
          $promo_point = $points_config->promo_point;
        }

        //calculate received points
        $received_points = intval(floor($promo_point * ($total_payable_amt / $promo_amount)));

        //start retailer_point_id generation
        $date_str                       = date('Ymd',strtotime("now"));
        $prefix                         = $date_str;
        $table                          = (new Invoice())->getTable();
        $col                            = 'id';
        $offset                         = 1;
        $pad_length                     = $configRepo->getDefaultIdPadLength(); //number of digits without prefix and date
        //generate id
        $retailer_point_id              = Utility::generate_id($prefix,$table,$col,$offset,$pad_length);
        //end retailer_point_id generation

        $retailer_id        = $paramObj->retailer_id;
        $retailshop_id      = $paramObj->retailshop_id;
        $brand_owner_id     = $paramObj->brand_owner_id;
        $invoice_id         = $paramObj->id;
        $used_points        = 0;
        $available_points   = $received_points;
        $total_points       = $received_points;
        $with_expiration    = $points_config->with_expiration;
        if($with_expiration == 1){
          //calculate expiry date
        } else{
          $expiry_date      = null;  //no expiry date
        }
        $remark             = null;
        $status             = 1; //active

        $pointObj                   = new RetailerPoint();
        $pointObj->id               = $retailer_point_id;
        $pointObj->retailer_id      = $retailer_id;
        $pointObj->retailshop_id    = $retailshop_id;
        $pointObj->brand_owner_id   = $brand_owner_id;
        $pointObj->invoice_id       = $invoice_id;
        $pointObj->used_points      = $used_points;
        $pointObj->available_points = $available_points;
        $pointObj->total_points     = $total_points;
        $pointObj->with_expiration  = $with_expiration;
        $pointObj->expiry_date      = $expiry_date;
        $pointObj->remark           = $remark;
        $pointObj->status           = $status;

        $point_result = $pointRepo->saveRetailerPoints($pointObj);

        if($point_result['aceplusStatusCode'] !== ReturnMessage::OK){
          //retailer point is not successfully saved, return with error
          DB::rollBack();
          return redirect()->action('Backend\InvoiceReportController@index')
              ->withMessage(FormatGenerator::message('Fail', 'Points are not saved...'));
        }
        //end retailer point

        // retailer point is successfully saved
        // start saving retailer point log
        //start retailer_point_id generation
        $date_str                       = date('Ymd',strtotime("now"));
        $prefix                         = $date_str;
        $table                          = (new Invoice())->getTable();
        $col                            = 'id';
        $offset                         = 1;
        $pad_length                     = $configRepo->getDefaultIdPadLength(); //number of digits without prefix and date
        //generate id
        $retailer_point_log_id          = Utility::generate_id($prefix,$table,$col,$offset,$pad_length);
        //end retailer_point_id generation

        $created_date       = $current_timestamp;
        $points             = $received_points;
        $retailer_reward_id = null;  //$retailer_reward_id is always null for status = 1 (Deliver type)
        $status             = 1;  //type is 1 (Deliver), or 0 (Reward Claim)

        //create log obj
        $pointLogObj                  = new RetailerPointLog();

        $pointLogObj->id                 = $retailer_point_log_id;
        $pointLogObj->retailer_point_id  = $retailer_point_id;
        $pointLogObj->created_date       = $created_date;
        $pointLogObj->points             = $points;
        $pointLogObj->retailer_reward_id = $retailer_reward_id;
        $pointLogObj->status             = $status;

        $point_log_result = $pointRepo->saveRetailerPointLog($pointLogObj);

        if($point_log_result['aceplusStatusCode'] !== ReturnMessage::OK){
          //retailer point is not successfully saved, return with error
          DB::rollBack();
          return redirect()->action('Backend\InvoiceReportController@index')
              ->withMessage(FormatGenerator::message('Fail', 'Point Log is not saved ...'));
        }
        //end saving retailer point log
        //end points
        DB::commit();

        return redirect()->action('Backend\InvoiceReportController@index')
            ->withMessage(FormatGenerator::message('Success', 'Invoice is delivered ...'));
      } else {
        return redirect()->action('Backend\InvoiceReportController@index')
            ->withMessage(FormatGenerator::message('Fail', 'Invoice is not delivered ...'));
      }
    }
    catch(\Exception $e){
        DB::rollBack();

        //create error log
        $date    = date("Y-m-d H:i:s");
        $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' delivered an invoice and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
        LogCustom::create($date,$message);

        $returnedObj['aceplusStatusMessage'] = $e->getMessage();
        return $returnedObj;
    }
  }

  public function cancelInvoice(){
    $invoice_id = Input::get('canceled_invoice_id');
    $paramObj = $this->repo->getObjByID($invoice_id);

    $currentUser = Utility::getCurrentUserID(); //get currently logged in user

    //change to cancel status
    $paramObj->status = StatusConstance::status_auderbox_cancel_value;
    $paramObj->cancel_by = $currentUser;
    $paramObj->cancel_date = date('Y-m-d H:i:s');

    $result = $this->repo->cancel($paramObj);

    if($result['aceplusStatusCode'] == ReturnMessage::OK) {
      //invoice header cancel is successful, continue canceling invoice details
      //start invoice detail cancel
      $invoice_id = $paramObj->id;
      $invoice_details = $this->repo->getInvoiceDetailsByInvoiceId($invoice_id);

      //cancel each invoice detail
      foreach($invoice_details as $invoice_detail){
        //set status to cancel
        $invoice_detail->status = StatusConstance::status_auderbox_cancel_value;
        $invoice_detail->cancel_by = $invoice_detail->cancel_by;
        $invoice_detail->cancel_date = $invoice_detail->cancel_date;

        $invoice_detail_result = $this->repo->cancelInvoiceDetail($invoice_detail);

        if($result['aceplusStatusCode'] !== ReturnMessage::OK) {
          return redirect()->action('Backend\InvoiceReportController@index')
              ->withMessage(FormatGenerator::message('Fail', 'Invoice is not canceled ...'));
        }
      }
      //end invoice detail cancel

      return redirect()->action('Backend\InvoiceReportController@index')
          ->withMessage(FormatGenerator::message('Success', 'Invoice canceled ...'));
    } else {
      return redirect()->action('Backend\InvoiceReportController@index')
          ->withMessage(FormatGenerator::message('Fail', 'Invoice is not canceled ...'));
    }
  }

  public function partialDeliverInvoice(){
    $invoice_detail_id = Input::get('partial_delivered_invoice_detail_id');

    $paramObj = $this->repo->getInvoiceDetailByID($invoice_detail_id);

    //to redirect to detail list page
    $invoice_id = $paramObj->invoice_id;

    //change to delivered status
    $paramObj->status = StatusConstance::status_deliver_value;

    $result = $this->repo->deliverInvoiceDetail($paramObj);

    if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Success', 'Invoice detail is delivered ...'));
    } else {
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Fail', 'Invoice detail is not delivered ...'));
    }
  }

  public function partialCancelInvoice(){
    $invoice_detail_id = Input::get('partial_canceled_invoice_detail_id');

    $paramObj = $this->repo->getInvoiceDetailByID($invoice_detail_id);

    $currentUser = Utility::getCurrentUserID(); //get currently logged in user

    $configRepo   = new ConfigRepository();
    $invoiceApiRepo = new InvoiceApiRepository();

    //to redirect to invoice list page
    $invoice_id = $paramObj->invoice_id;

    //change to canceled status
    $paramObj->status = StatusConstance::status_auderbox_cancel_value;
    $paramObj->cancel_by = $currentUser;
    $paramObj->cancel_date = date('Y-m-d H:i:s');

    $result = $this->repo->cancelInvoiceDetail($paramObj);

    if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
      //if invoice_detail cancellation is successful
      //get invoice header obj
      $paramHeaderObj = $this->repo->getObjByID($invoice_id);

      //start updating header price
      $canceled_detail_net_amount = $paramObj->net_amt;
      $canceled_detail_net_amount_w_disc = $paramObj->net_amt_w_disc;
      $canceled_detail_payable_amount = $paramObj->payable_amt;

      //reduce cancel detail amounts
      $paramHeaderObj->total_net_amt = $paramHeaderObj->total_net_amt - $canceled_detail_net_amount;
      $paramHeaderObj->total_net_amt_w_disc = $paramHeaderObj->total_net_amt_w_disc - $canceled_detail_net_amount_w_disc;
      $paramHeaderObj->total_payable_amt = $paramHeaderObj->total_payable_amt - $canceled_detail_payable_amount;

      $update_header_price_result = $this->repo->updateHeaderPrice($paramHeaderObj);

      if ($update_header_price_result['aceplusStatusCode'] !== ReturnMessage::OK) {
        return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
            ->withMessage(FormatGenerator::message('Fail', 'Invoice detail is canceled but invoice header price is not updated...'));
      }
      //end updating header price

      // start recalculate promotion
      //clear old invoice_promotion data with invoice id
      $delete_invoice_promotion_result = $this->repo->clearInvoicePromotionByInvoiceId($invoice_id);

      $invoice_details = $this->repo->getInvoiceDetailsByInvoiceId($invoice_id);

      if(isset($invoice_details) && count($invoice_details) > 0){
        foreach($invoice_details as $key=>$inv_detail){
          $product_quantity_array[$key]["product_id"] = $inv_detail->product_id;
          $product_quantity_array[$key]["quantity"]   = $inv_detail->quantity;
          $product_quantity_array[$key]["retailshop_id"]   = $paramHeaderObj->retailshop_id;
        }

        $recalculate_promotion_result = $this->calculatePromotion($product_quantity_array);
        // end recalculate promotion

        //start invoice promotion
        if($recalculate_promotion_result['aceplusStatusCode'] == ReturnMessage::OK){
            $recalculate_promotion_data = $recalculate_promotion_result['data'][0];

            $received_promotion  = $recalculate_promotion_data['received_promotion'];
            $product_array = $recalculate_promotion_data['product_array'];
            $promo_product_array = $recalculate_promotion_data['promo_product_array'];

            $current_timestamp = date('Y-m-d H:i:s');  //get current timestamp

            foreach($promo_product_array as $gift){
              //start invoice_promotion_id generation
              $date_str                       = date('Ymd',strtotime("now"));
              $prefix                         = $date_str;
              $table                          = (new InvoicePromotion())->getTable();
              $col                            = 'id';
              $offset                         = 1;
              $pad_length                     = $configRepo->getDefaultIdPadLength(); //number of digits without prefix and date
              //generate id
              $invoice_promotion_id           = Utility::generate_id($prefix,$table,$col,$offset,$pad_length);
              //end invoice_promotion_id generation

              $invoicePrmotionObj = new InvoicePromotion();
              $invoicePrmotionObj->id                       = $invoice_promotion_id;
              $invoicePrmotionObj->promotion_item_level_id  = $gift->promotion_item_level_id;
              $invoicePrmotionObj->invoice_id               = $invoice_id;
              $invoicePrmotionObj->product_id               = $gift->promo_product_id;
              $invoicePrmotionObj->qty                      = $gift->received_promo_qty;
              $invoicePrmotionObj->date                     = $current_timestamp;

              $invoice_promotion_result                     = $invoiceApiRepo->saveInvoicePromotion($invoicePrmotionObj);

              //if saving invoice promotion fails,
              if($invoice_promotion_result['aceplusStatusCode'] != ReturnMessage::OK){
                DB::rollback();
                return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
                    ->withMessage(FormatGenerator::message('Message', $invoice_promotion_result['aceplusStatusMessage']));
              }
            }
        }
      }
      //end invoice promotion

      //check if all invoice details are canceled, if yes, update header status to canceled
      $all_details_canceled_flag = $this->repo->checkAllInvoiceDetailsAreCanceledOrNot($invoice_id);

      //if all invoice_details are canceled, start canceling header
      if(isset($all_details_canceled_flag) && $all_details_canceled_flag == true){
          $currentUser = Utility::getCurrentUserID(); //get currently logged in user

          //change to cancel status
          $paramHeaderObj->status = StatusConstance::status_auderbox_cancel_value;
          $paramHeaderObj->cancel_by = $currentUser;
          $paramHeaderObj->cancel_date = date('Y-m-d H:i:s');

          $header_result = $this->repo->cancel($paramHeaderObj);

          //if canceling header is successful too, redirect to invoice detail page
          if ($header_result['aceplusStatusCode'] == ReturnMessage::OK) {
            return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
                ->withMessage(FormatGenerator::message('Success', 'Invoice detail (also invoice) is canceled ...'));
          } else {
            return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
                ->withMessage(FormatGenerator::message('Fail', 'Invoice detail (also invoice) is not canceled ...'));
          }
      }
      //end canceling header

      /*
      //start invoice_detail_history
      $configRepo = new ConfigRepository();
      //start generating invoice_detail_history_id
      $invoice_detail_history_table      = (new InvoiceDetailHistory())->getTable();
      $invoice_detail_history_col        = 'id';
      $invoie_detail_history_offset      = 1;
      $invoice_detail_history_pad_length = $configRepo->getInvoiceDetailIdPadLength()[0]->value; //number of digits without prefix and date
      $detail_history_id                 = Utility::generate_id($invoice_detail_id,$invoice_detail_history_table,$invoice_detail_history_col,$invoie_detail_history_offset,$invoice_detail_history_pad_length);
      //end generating invoice_detail_history_id

      $invDetailHistoryObj = new InvoiceDetailHistory();
      $invDetailHistoryObj->id = $detail_history_id;
      $invDetailHistoryObj->invoice_detail_id = $invoice_detail_id;
      $invDetailHistoryObj->qty = -1 * abs($paramObj->quantity); //negative value, because of cancel action
      $invDetailHistoryObj->date = date('Y-m-d H:i:s');
      $invDetailHistoryObj->type = CoreConstance::invoice_detail_order_value; //invoice_history_type is "order"
      $invDetailHistoryObj->status = 1; //default is active

      $detailHistoryRes = $this->repo->saveInvoiceDetailHistory($invDetailHistoryObj);

      if($detailHistoryRes['aceplusStatusCode'] != ReturnMessage::OK){
        DB::rollback();
        $returnedObj['aceplusStatusCode']     = $detailHistoryRes['aceplusStatusCode'];
        $returnedObj['aceplusStatusMessage']  = $detailHistoryRes['aceplusStatusMessage'];
        return $returnedObj;
      }
      //end invoice_detail_history
      */

      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Success', 'Invoice detail is canceled ...'));
    } else {
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Fail', 'Invoice detail is not canceled ...'));
    }
  }

  public function exportCSV($from_date = null, $to_date = null, $status = null) {
    if (Auth::guard('User')->check()) {
      ob_end_clean();
      ob_start();

      //get invoices
      $invoices = $this->repo->getInvoiceList($from_date,$to_date,$status);

      //array to store final export format
      $invoice_export_array = array();

      //counter for export array
      $count = 0;

      if(isset($invoices) && count($invoices) > 0){
        foreach($invoices as $invoice_header){
          /*
          //all statuses
          //get status text according to status (integer)
          if($invoice_header->status == StatusConstance::status_pending_value){
            $invoice_header->status_text = StatusConstance::status_pending_description;
          }
          else if($invoice_header->status == StatusConstance::status_confirm_value){
            $invoice_header->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_header->status == StatusConstance::status_deliver_value){
            $invoice_header->status_text = StatusConstance::status_deliver_description;
          }
          else if($invoice_header->status == StatusConstance::status_retailer_cancel_value){
            $invoice_header->status_text = StatusConstance::status_retailer_cancel_description;
          }
          else if($invoice_header->status == StatusConstance::status_brand_owner_cancel_value){
            $invoice_header->status_text = StatusConstance::status_brand_owner_cancel_description;
          }
          else{
            $invoice_header->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          */

          /*
          //for pilot version
          if($invoice_header->status == StatusConstance::status_confirm_value){
            $invoice_header->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_header->status == StatusConstance::status_deliver_value){
            $invoice_header->status_text = StatusConstance::status_deliver_description;
          }
          else{
            $invoice_header->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          //for pilot version
          //end status text
          */

          $invoice_id = $invoice_header->id;

          //start invoice_detail
          $invoice_with_detail = $this->repo->getInvoiceDetail($invoice_id);

          foreach($invoice_with_detail->invoice_details as $invoice_detail){
            //construct array to export in excel
            $invoice_export_array[$count]['Invoice Number']         = $invoice_with_detail->id;
            $invoice_export_array[$count]['Shop Name']              = $invoice_with_detail->retailshop_name_eng;
            $invoice_export_array[$count]['Shop Address']           = $invoice_with_detail->retailshop_address;
            $invoice_export_array[$count]['Retailer Name']          = $invoice_with_detail->retailer_name_eng;
            $invoice_export_array[$count]['Retailer Phone Number']  = $invoice_with_detail->retailer_phone;
            $invoice_export_array[$count]['Brand Owner']            = $invoice_detail->brand_owner_name;
            $invoice_export_array[$count]['Product Name']           = $invoice_detail->product_name;
            $invoice_export_array[$count]['SKU']                    = $invoice_detail->sku;
            $invoice_export_array[$count]['Product Quantity']       = $invoice_detail->quantity;
            $invoice_export_array[$count]['Order Date']             = $invoice_with_detail->order_date;
            $invoice_export_array[$count]['Delivery Date']          = $invoice_with_detail->delivery_date;
            $invoice_export_array[$count]['Amount']                 = $invoice_detail->payable_amt;
            $invoice_export_array[$count]['Status']                 = $invoice_detail->status_text;

            //increase counter
            $count++;
          }
          //end invoice_detail

          //start invoice promotion
          $promo_product_array = array();
          $productApiRepo     = new ProductApiRepository();
          $shopListApiRepo    = new ShopListApiRepository();

          $retailshop_id = $invoice_header->retailshop_id;
          //get retailshop object
          $retailshop = $shopListApiRepo->getShopById($retailshop_id);
          //get retailshop ward id
          $retailshop_address_ward_id = $retailshop->address_ward_id;

          //get invoice promotions by invoice_id
          $invoice_promotions = $this->repo->getInvoicePromotionsByInvoiceId($invoice_id);

          foreach($invoice_promotions as $invoice_promotion){
            $promo_product_id = $invoice_promotion->product_id;
            $promo_qty        = $invoice_promotion->qty;

            //get product detail including price
            $promo_product_detail_result = $productApiRepo->getProductDetailByID($promo_product_id,$retailshop_address_ward_id);

            if($promo_product_detail_result['aceplusStatusCode'] !== ReturnMessage::OK){
              $returnedObj['aceplusStatusCode']     = $promo_product_detail_result['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $promo_product_detail_result['aceplusStatusMessage'];
              return \Response::json($returnedObj);
            }
            $promo_product_detail               = $promo_product_detail_result['resultObj'];
            $promo_product_detail->quantity     = $promo_qty;
            $promo_product_detail->payable_amt  = 0.0;  //because this is present item
            $promo_product_detail->status_text  = "Gift Item";

            array_push($promo_product_array,$promo_product_detail);
          }

          //start adding invoice_promotions to export array
          foreach($promo_product_array as $invoice_promotion){
            //construct array to export in excel
            $invoice_export_array[$count]['Invoice Number']         = $invoice_with_detail->id;
            $invoice_export_array[$count]['Shop Name']              = $invoice_with_detail->retailshop_name_eng;
            $invoice_export_array[$count]['Shop Address']           = $invoice_with_detail->retailshop_address;
            $invoice_export_array[$count]['Retailer Name']          = $invoice_with_detail->retailer_name_eng;
            $invoice_export_array[$count]['Retailer Phone Number']  = $invoice_with_detail->retailer_phone;
            $invoice_export_array[$count]['Brand Owner']            = $invoice_promotion->brand_owner_name;
            $invoice_export_array[$count]['Product Name']           = $invoice_promotion->name;
            $invoice_export_array[$count]['SKU']                    = $invoice_promotion->sku;
            $invoice_export_array[$count]['Product Quantity']       = $invoice_promotion->quantity;
            $invoice_export_array[$count]['Order Date']             = $invoice_with_detail->order_date;
            $invoice_export_array[$count]['Delivery Date']          = $invoice_with_detail->delivery_date;
            $invoice_export_array[$count]['Amount']                 = $invoice_promotion->payable_amt;
            $invoice_export_array[$count]['Status']                 = $invoice_promotion->status_text;

            //increase counter
            $count++;
          }
          //end adding invoice_promotions to export array
          //end invoice promotion
        }
      }

      $today_date = date('d-m-Y');
      Excel::create($today_date.'_InvoiceReport', function($excel)use($invoice_export_array) {
              $excel->sheet('InvoiceReport', function($sheet)use($invoice_export_array) {

                  if(count($invoice_export_array) == 0){
                      $sheet->fromArray($invoice_export_array);
                  }
                  else{
                      $sheet->cells('A1:F1', function($cells) {
                          $cells->setBackground('#F37075');
                          $cells->setFontSize(13);
                      });

                      $sheet->fromArray($invoice_export_array);
                  }
              });
          })
              ->download('csv');
          ob_flush();
          return Redirect();
    }
    else{
      return redirect('backend/unauthorize');
    }
  }

  public function changeDetailQuantity() {
    DB::beginTransaction();
    $quantity_change_invoice_detail_id = Input::get('quantity_change_invoice_detail_id');
    // $reduced_quantity = Input::get('reduced_qty');
    $new_quantity = Input::get('new_qty');

    $configRepo = new ConfigRepository();
    $invoiceApiRepo = new InvoiceApiRepository();

    $paramDetailObj = $this->repo->getInvoiceDetailByID($quantity_change_invoice_detail_id);

    //to redirect to detail list page
    $invoice_id = $paramDetailObj->invoice_id;

    //get reduced_qty from original qty
    $reduced_quantity = $paramDetailObj->quantity - $new_quantity;

    //record old invoice detail amounts
    $old_detail_net_amt         = $paramDetailObj->net_amt;
    $old_detail_net_amt_w_disc  = $paramDetailObj->net_amt_w_disc;
    $old_detail_payable_amt     = $paramDetailObj->payable_amt;

    if($new_quantity == 0){
      //set new invoice detail amounts to zero
      $new_detail_net_amt        = 0.0;
      $new_detail_discount_amt   = $paramDetailObj->discount_amt; //same for pilot version (there is no discount)
      $new_detail_net_amt_w_disc = 0.0;
      $new_detail_payable_amt    = 0.0;
    }
    else{
      //recalculate new invoice detail amounts
      $new_detail_net_amt         = $paramDetailObj->unit_price * $new_quantity;
      $new_detail_discount_amt    = $paramDetailObj->discount_amt; //same for pilot version (there is no discount)
      $new_detail_net_amt_w_disc  = $new_detail_net_amt - $new_detail_discount_amt;

      $tax_amount                 = Utility::calculateTaxAmount($new_detail_net_amt_w_disc);  //calculate tax amount
      $new_detail_payable_amt     = $new_detail_net_amt_w_disc + $tax_amount;
    }

    //calculate canceled detail amounts
    $canceled_detail_net_amt        = $old_detail_net_amt - $new_detail_net_amt;
    $canceled_detail_net_amt_w_disc = $old_detail_net_amt_w_disc - $new_detail_net_amt_w_disc;
    $canceled_detail_payable_amt    = $old_detail_payable_amt - $new_detail_payable_amt;


    //update invoice detail obj with new qty and amounts
    if($new_quantity == 0) {
      $paramDetailObj->status       = StatusConstance::status_auderbox_cancel_value;
    }
    $paramDetailObj->quantity       = $new_quantity;
    $paramDetailObj->net_amt        = $new_detail_net_amt;
    $paramDetailObj->net_amt_w_disc = $new_detail_net_amt_w_disc;
    $paramDetailObj->payable_amt    = $new_detail_payable_amt;

    $change_quantity_result = $this->repo->changeQuantity($paramDetailObj);

    if ($change_quantity_result['aceplusStatusCode'] !== ReturnMessage::OK) {
      DB::rollback();
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Fail', 'Invoice detail quantity is not updated ...'));
    }

    //if quantity change is successful, then update invoice_header's amounts
    //get invoice header obj
    $paramHeaderObj = $this->repo->getObjByID($invoice_id);

    //reduce cancel detail amounts
    $paramHeaderObj->total_net_amt = $paramHeaderObj->total_net_amt - $canceled_detail_net_amt;
    $paramHeaderObj->total_net_amt_w_disc = $paramHeaderObj->total_net_amt_w_disc - $canceled_detail_net_amt_w_disc;
    $paramHeaderObj->total_payable_amt = $paramHeaderObj->total_payable_amt - $canceled_detail_payable_amt;

    $update_header_price_result = $this->repo->updateHeaderPrice($paramHeaderObj);

    if ($update_header_price_result['aceplusStatusCode'] !== ReturnMessage::OK) {
      DB::rollback();
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Fail', 'Invoice detail is updated but invoice header price is not updated...'));
    }
    //end updating header price

    //check if all invoice details are canceled, if yes, update header status to canceled
    $all_details_canceled_flag = $this->repo->checkAllInvoiceDetailsAreCanceledOrNot($invoice_id);

    //if all invoice_details are canceled, start canceling header
    if(isset($all_details_canceled_flag) && $all_details_canceled_flag == true){
        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        //change to cancel status
        $paramHeaderObj->status = StatusConstance::status_auderbox_cancel_value;
        $paramHeaderObj->cancel_by = $currentUser;
        $paramHeaderObj->cancel_date = date('Y-m-d H:i:s');

        $header_result = $this->repo->cancel($paramHeaderObj);

        //if canceling header fails, redirect to invoice detail page
        if ($header_result['aceplusStatusCode'] !== ReturnMessage::OK) {
          DB::rollback();
          return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
              ->withMessage(FormatGenerator::message('Fail', 'Invoice detail (also invoice) is not canceled ...'));
        }
    }
    //end canceling header

    //start invoice_detail_history
    $configRepo = new ConfigRepository();
    //start generating invoice_detail_history_id
    $invoice_detail_history_table      = (new InvoiceDetailHistory())->getTable();
    $invoice_detail_history_col        = 'id';
    $invoie_detail_history_offset      = 1;
    $invoice_detail_history_pad_length = $configRepo->getInvoiceDetailIdPadLength()[0]->value; //number of digits without prefix and date
    $detail_history_id                 = Utility::generate_id($quantity_change_invoice_detail_id,$invoice_detail_history_table,$invoice_detail_history_col,$invoie_detail_history_offset,$invoice_detail_history_pad_length);
    //end generating invoice_detail_history_id

    $invDetailHistoryObj = new InvoiceDetailHistory();
    $invDetailHistoryObj->id = $detail_history_id;
    $invDetailHistoryObj->invoice_detail_id = $quantity_change_invoice_detail_id;
    $invDetailHistoryObj->qty = -1 * abs($reduced_quantity); //negative value, because of cancel action
    $invDetailHistoryObj->date = date('Y-m-d H:i:s');
    $invDetailHistoryObj->type = CoreConstance::invoice_detail_order_value; //invoice_history_type is "order"
    $invDetailHistoryObj->status = 1; //default is active

    $detailHistoryRes = $this->repo->saveInvoiceDetailHistory($invDetailHistoryObj);

    if($detailHistoryRes['aceplusStatusCode'] != ReturnMessage::OK){
      DB::rollback();
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Message', $detailHistoryRes['aceplusStatusMessage']));
    }
    //end invoice_detail_history

    //start recalculating promotions
    //clear old invoice_promotion data with invoice id
    $delete_invoice_promotion_result = $this->repo->clearInvoicePromotionByInvoiceId($invoice_id);

    $invoice_id = $paramHeaderObj->id;

    $product_quantity_array = array();

    $invoice_details = $this->repo->getInvoiceDetailsByInvoiceId($invoice_id);

    if(isset($invoice_details) && count($invoice_details) > 0){
      foreach($invoice_details as $key=>$inv_detail){
        $product_quantity_array[$key]["product_id"] = $inv_detail->product_id;
        $product_quantity_array[$key]["quantity"]   = $inv_detail->quantity;
        $product_quantity_array[$key]["retailshop_id"]   = $paramHeaderObj->retailshop_id;
      }

      $recalculate_promotion_result = $this->calculatePromotion($product_quantity_array);

      // if($recalculate_promotion_result['aceplusStatusCode'] != ReturnMessage::OK){
      //   DB::rollback();
      //   return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
      //       ->withMessage(FormatGenerator::message('Message', $recalculate_promotion_result['aceplusStatusMessage']));
      // }
      //end recalculating promotions

      //start invoice promotion
      if($recalculate_promotion_result['aceplusStatusCode'] == ReturnMessage::OK){
          $recalculate_promotion_data = $recalculate_promotion_result['data'][0];

          $received_promotion  = $recalculate_promotion_data['received_promotion'];
          $product_array = $recalculate_promotion_data['product_array'];
          $promo_product_array = $recalculate_promotion_data['promo_product_array'];

          $current_timestamp = date('Y-m-d H:i:s');  //get current timestamp

          foreach($promo_product_array as $gift){
            //start invoice_promotion_id generation
            $date_str                       = date('Ymd',strtotime("now"));
            $prefix                         = $date_str;
            $table                          = (new InvoicePromotion())->getTable();
            $col                            = 'id';
            $offset                         = 1;
            $pad_length                     = $configRepo->getDefaultIdPadLength(); //number of digits without prefix and date
            //generate id
            $invoice_promotion_id           = Utility::generate_id($prefix,$table,$col,$offset,$pad_length);
            //end invoice_promotion_id generation

            $invoicePrmotionObj = new InvoicePromotion();
            $invoicePrmotionObj->id                       = $invoice_promotion_id;
            $invoicePrmotionObj->promotion_item_level_id  = $gift->promotion_item_level_id;
            $invoicePrmotionObj->invoice_id               = $invoice_id;
            $invoicePrmotionObj->product_id               = $gift->promo_product_id;
            $invoicePrmotionObj->qty                      = $gift->received_promo_qty;
            $invoicePrmotionObj->date                     = $current_timestamp;

            $invoice_promotion_result                     = $invoiceApiRepo->saveInvoicePromotion($invoicePrmotionObj);

            //if saving invoice promotion fails,
            if($invoice_promotion_result['aceplusStatusCode'] != ReturnMessage::OK){
              DB::rollback();
              return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
                  ->withMessage(FormatGenerator::message('Message', $invoice_promotion_result['aceplusStatusMessage']));
            }
          }
      }
    }
    //end invoice promotion

    if ($change_quantity_result['aceplusStatusCode'] == ReturnMessage::OK) {
      DB::commit();
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Success', 'Invoice detail quantity and invoice header price is updated ...'));
    } else {
      DB::rollback();
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Fail', 'Invoice detail quantity is not updated ...'));
    }
  }

  public function calculatePromotion($product_quantity_array){
    $promotionRepo  = new PromotionApiRepository();
    $productRepo    = new ProductRepository();
    $retailshopRepo = new RetailshopRepository();

    //input product ids
    $product_id_array = array();

    foreach($product_quantity_array as $product_quantity) {
      //get only product_id
      array_push($product_id_array,$product_quantity['product_id']);
    }

    //get today date to get available item level promotion groups
    $today_date = date('Y-m-d');

    //array to store promotion item levels
    $promotion_item_level_array = array();

    // array to store promotion detail information
    $promotion_item_level_detail_array = array();

    //get promotion groups
    $promotion_item_level_groups = $promotionRepo->getAvailablePromotionItemLevelGroups($today_date);

    //if there is no available item level promo group for today, just return
    if(!(isset($promotion_item_level_groups) && count($promotion_item_level_groups) > 0)) {
      $returnedObj['aceplusStatusCode']     = ReturnMessage::NO_CONTENT;
      $returnedObj['aceplusStatusMessage']  = "No item level promotion group available today !";
      return $returnedObj;
    }

    //no need to check alerted promotion in backend (only in api)
    $alerted_promotion_id_array = [];

    foreach($promotion_item_level_groups as $promotion_item_level_group) {
      $group_id = $promotion_item_level_group->id;
      $promotion_item_levels = $promotionRepo->getPromotionItemLevelByGroupId($group_id, $today_date,$alerted_promotion_id_array);

      foreach($promotion_item_levels as $promotion_item_level){
        array_push($promotion_item_level_array, $promotion_item_level);
      }
    }

    // there are no item level promotion, just return
    if(count($promotion_item_level_array) == 0) {
      $returnedObj['aceplusStatusCode']     = ReturnMessage::NO_CONTENT;
      $returnedObj['aceplusStatusMessage']  = "No item level promotion available today !";
      return $returnedObj;
    }

    foreach($promotion_item_level_array as $promotion_item_level_value){
      $promotion_item_level_id = $promotion_item_level_value->id;
      $promotion_item_level_details = $promotionRepo->getPromotionItemLevelDetailByLevelId($promotion_item_level_id, $today_date);

      $product_id_count = 0; //start counter

      //reset arrays
      $promotion_item_level_detail_array = array();
      $product_array_included_in_promotion = array();

      foreach($promotion_item_level_details as $promotion_item_level_detail) {
        //add to detail array
        // $promotion_item_level_detail_array[$promotion_item_level_id][$product_id_count] = $promotion_item_level_detail->product_id;
        array_push($promotion_item_level_detail_array,$promotion_item_level_detail->product_id);
        $product_id_count++;
      }

      if(count($promotion_item_level_detail_array) == 0) {
        $returnedObj['aceplusStatusCode']     = ReturnMessage::NO_CONTENT;
        $returnedObj['aceplusStatusMessage']  = "No item level promotion detail available today !";
        return $returnedObj;
      }

      //bind to promotion_item_level_obj
      $promotion_item_level_value->promotion_product_id_array = $promotion_item_level_detail_array;
      // foreach($product_id_array as $product_id){
      foreach($product_quantity_array as $product_quantity){
        if(in_array($product_quantity['product_id'] , $promotion_item_level_detail_array)){
          // $productObj = $productRepo->getObjByID($product_id);
          array_push($product_array_included_in_promotion, $product_quantity);
        }
      }

      $promotion_item_level_value->product_array_included_in_promotion = $product_array_included_in_promotion;
    }

    //array to store only valid promotions
    $valid_promotions = array();

    // start getting only valid promotions
    // the promotion is valid only if input product id is included in product_array_included_in_promotion
    foreach($promotion_item_level_array as $promotion_item_level){
      if(count($promotion_item_level->product_array_included_in_promotion) > 0) {
        array_push($valid_promotions,$promotion_item_level);
      }
    }
    //end getting only valid promotions

    foreach($valid_promotions as $valid_promotion){
        $products_that_match_promotion = $valid_promotion->product_array_included_in_promotion;

        //if purchase type is qty
        if($valid_promotion->promo_purchase_type == PromotionConstance::promotion_quantity_value){
          $input_purchase_qty_for_promo = 0;
          foreach($products_that_match_promotion as $product_that_match_promotion) {
            $input_purchase_qty_for_promo += $product_that_match_promotion['quantity'];
          }

          $item_level_promotion_id = $valid_promotion->id;

          //*****get promotion obj only if there are cart items that match the promotion
          if(count($valid_promotion->product_array_included_in_promotion) > 0) {
            //if cart_purchase_qty is greater than or equal to promo_purchase_qty
            if(($input_purchase_qty_for_promo >= $valid_promotion->purchase_qty)) {
              $promotionObj = $valid_promotion;
              break;
            }
          }
        }
    }

    if(isset($promotionObj) && count($promotionObj) > 0) {
        //start checking promo_purchase_type
        if($promotionObj->promo_purchase_type == PromotionConstance::promotion_quantity_value) {
          $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_quantity_description;
        }
        else if($promotionObj->promo_purchase_type == PromotionConstance::promotion_amount_value) {
          $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_amount_description;
        }
        else if($promotionObj->promo_purchase_type == PromotionConstance::promotion_percentage_value) {
          $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_percentage_description;
        }
        //end checking promo_purchase_type

        //start checking promo_present_type
        if($promotionObj->promo_present_type == PromotionConstance::promotion_quantity_value) {
          $promotionObj->promo_present_type_text = PromotionConstance::promotion_quantity_description;
        }
        else if($promotionObj->promo_present_type == PromotionConstance::promotion_amount_value) {
          $promotionObj->promo_present_type_text = PromotionConstance::promotion_amount_description;
        }
        else if($promotionObj->promo_present_type == PromotionConstance::promotion_percentage_value) {
          $promotionObj->promo_present_type_text = PromotionConstance::promotion_percentage_description;
        }
        //end checking promo_present_type

        $current_purchase_qty = 0; // for currently purchased qty
        $current_purchase_amt = 0; // for currently purchased amt
        $purchased_products_array = array(); //to store details of purchased products
        $promo_products_array = array(); //to store details of promo products

        //start total_qurchase_qty, total_purchase_amt, and purchased_products_array
        foreach($promotionObj->product_array_included_in_promotion as $product_included_in_promotion){
          //calculate total purchase qty
          $current_purchase_qty += $product_included_in_promotion['quantity'];

          //start calculating total purchase amount
          $product_id          = $product_included_in_promotion['product_id'];
          $retailshop_id       = $product_included_in_promotion['retailshop_id'];

          //get retailshop object
          $retailshop = $retailshopRepo->getObjById($retailshop_id);

          //get retailshop ward id
          $retailshop_address_ward_id = $retailshop->address_ward_id;

          //get product detail including price
          $product_detail_result = $productRepo->getProductDetailByID($product_id,$retailshop_address_ward_id);

          //if getting product details is not successful, return with error message
          if($product_detail_result["aceplusStatusCode"] !== ReturnMessage::OK){
            $returnedObj['aceplusStatusCode']     = $product_detail_result["aceplusStatusCode"];
            $returnedObj['aceplusStatusMessage']  = $product_detail_result["aceplusStatusMessage"];
            return $returnedObj;
          }

          //get product_detail obj
          $product_detail = $product_detail_result["resultObj"];

          // //define minimum_order_qty and maximum_order_qty (temporarily hard-coded for now)
          // $product_detail->minimum_order_qty = 1;
          // $product_detail->maximum_order_qty = 50;
          $product_detail->purchase_qty      = $product_included_in_promotion['quantity'];

          //push product detail to product array
          array_push($purchased_products_array,$product_detail);

          //add each product's [price*quantity] to current total purchase amount
          $current_purchase_amt += $product_detail->price * $product_detail->purchase_qty;
          //end calculating total purchase amount
        }

        $promotionObj->current_purchase_qty = $current_purchase_qty;
        $promotionObj->current_purchase_amt = $current_purchase_amt;
        //end total_qurchase_qty, total_purchase_amt, and purchased_products_array

        // start getting promo_product_array
        //only qty promotions for now
        if($promotionObj->promo_present_type = PromotionConstance::promotion_quantity_value){
          $promotion_gifts = $promotionRepo->getPromotionItemLevelGiftsByLevelId($promotionObj->id);

          if(count($promotion_gifts) == 0) {
            $returnedObj['aceplusStatusCode']     = ReturnMessage::NO_CONTENT;
            $returnedObj['aceplusStatusMessage']  = "No promotion gift available!";
            return $returnedObj;
          }
        }
        // end getting promo_product_array

        //calculate received promo product qty for each promo product
        foreach($promotion_gifts as $promo_gift) {
          if($promotionObj->promo_present_type == PromotionConstance::promotion_quantity_value && $promotionObj->purchase_qty !== 0){
            //get received promo qty (eg. if promo_purchase_qty is 5 and user currently buy a total of 16, the received promo qty is [int(16/5) = 3])
            $received_promo_qty = intval(floor($promotionObj->current_purchase_qty / $promotionObj->purchase_qty));
            $promo_gift->received_promo_qty = $received_promo_qty;
          }
        }

        //get all products included in current promotion
        $product_id_array_included_in_promotion = array();

        // foreach($cart_item_array_included_in_promotion as $cart_item_obj_in_promotion){
        foreach($promotionObj->product_array_included_in_promotion as $product_in_promotion){
          array_push($product_id_array_included_in_promotion,$product_in_promotion['product_id']);
        }

        //here is all product ids in current promotion
        $all_product_ids_in_promotion = $promotionObj->promotion_product_id_array;

        //array to store purchased_products from promotion
        $total_product_array = array();
        $total_product_array_index = 0;

        // start binding all products to $total_product_array
        foreach($purchased_products_array as $purchased_product){
          $total_product_array[$total_product_array_index]['id']                          = $purchased_product->id;
          $total_product_array[$total_product_array_index]['name']                        = $purchased_product->name;
          $total_product_array[$total_product_array_index]['image']                       = $purchased_product->image;
          $total_product_array[$total_product_array_index]['sku']                         = $purchased_product->sku;
          $total_product_array[$total_product_array_index]['remark']                      = $purchased_product->remark;
          $total_product_array[$total_product_array_index]['price']                       = $purchased_product->price;
          $total_product_array[$total_product_array_index]['product_uom_type_name_eng']   = $purchased_product->product_uom_type_name_eng;
          $total_product_array[$total_product_array_index]['product_uom_type_name_mm']    = $purchased_product->product_uom_type_name_mm;
          $total_product_array[$total_product_array_index]['product_volume_type_name']    = $purchased_product->product_volume_type_name;
          $total_product_array[$total_product_array_index]['product_container_type_name'] = $purchased_product->product_container_type_name;
          $total_product_array[$total_product_array_index]['total_uom_quantity']          = $purchased_product->total_uom_quantity;
          $total_product_array[$total_product_array_index]['minimum_order_qty']           = $purchased_product->minimum_order_qty;
          $total_product_array[$total_product_array_index]['maximum_order_qty']           = $purchased_product->maximum_order_qty;
          $total_product_array[$total_product_array_index]['purchase_qty']                = $purchased_product->purchase_qty;
          $total_product_array_index++;
        }
        // end binding all products to $total_product_array

        //everything is ok
        $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage']  = "Promotion calculation is successful !";
        $returnedObj['data'] = array();
        $returnedObj['data'][0]["received_promotion"]   = $promotionObj;
        // $returnedObj['data'][0]["product_array"]        = $purchased_products_array;
        $returnedObj['data'][0]["product_array"]        = $total_product_array;
        $returnedObj['data'][0]["promo_product_array"]  = $promotion_gifts;
        // $returnedObj['data'][0]["current_purchase_qty"] = $current_purchase_qty;

        return $returnedObj;
    }

    $returnedObj['aceplusStatusCode']     = ReturnMessage::NO_CONTENT;
    $returnedObj['aceplusStatusMessage']  = "No promotion available!";
    return $returnedObj;

  }
}
