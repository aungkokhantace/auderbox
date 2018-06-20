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

  public function invoiceDetail($invoice_id) {
    if (Auth::guard('User')->check()) {
      //get invoice details
      $invoice = $this->repo->getInvoiceDetail($invoice_id);

      return view('report.invoice_report.invoice_detail')
          ->with('invoice',$invoice);
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
        // dd('paramObj',$pointObj);
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

    //to redirect to detail list page
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
    $quantity_change_invoice_detail_id = Input::get('quantity_change_invoice_detail_id');
    // $reduced_quantity = Input::get('reduced_qty');
    $new_quantity = Input::get('new_qty');

    $configRepo = new ConfigRepository();

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
      $returnedObj['aceplusStatusCode']     = $detailHistoryRes['aceplusStatusCode'];
      $returnedObj['aceplusStatusMessage']  = $detailHistoryRes['aceplusStatusMessage'];
      return $returnedObj;
    }
    //end invoice_detail_history

    if ($change_quantity_result['aceplusStatusCode'] == ReturnMessage::OK) {
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Success', 'Invoice detail quantity and invoice header price is updated ...'));
    } else {
      return redirect()->action('Backend\InvoiceReportController@invoiceDetail', ['invoice_id' => $invoice_id])
          ->withMessage(FormatGenerator::message('Fail', 'Invoice detail quantity is not updated ...'));
    }
  }
}
