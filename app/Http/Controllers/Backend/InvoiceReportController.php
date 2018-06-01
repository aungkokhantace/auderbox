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
          else if($invoice_header->status == StatusConstance::status_retailer_cancel_value){
            $invoice_header->status_text = StatusConstance::status_retailer_cancel_description;
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
            $invoice_header->status_text = StatusConstance::status_retailer_cancel_description;
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

    //change to delivered status
    $paramObj->status = StatusConstance::status_deliver_value;

    $result = $this->repo->deliver($paramObj);

    if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
      return redirect()->action('Backend\InvoiceReportController@index')
          ->withMessage(FormatGenerator::message('Success', 'Invoice delivered ...'));
    } else {
      return redirect()->action('Backend\InvoiceReportController@index')
          ->withMessage(FormatGenerator::message('Fail', 'Invoice is not delivered ...'));
    }
  }

  public function cancelInvoice(){
    $invoice_id = Input::get('canceled_invoice_id');
    $paramObj = $this->repo->getObjByID($invoice_id);

    $currentUser = Utility::getCurrentUserID(); //get currently logged in user

    //change to cancel status
    $paramObj->status = StatusConstance::status_retailer_cancel_value;
    $paramObj->cancel_by = $currentUser;
    $paramObj->cancel_date = date('Y-m-d H:i:s');

    $result = $this->repo->cancel($paramObj);

    if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
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
    $paramObj->status = StatusConstance::status_retailer_cancel_value;
    $paramObj->cancel_by = $currentUser;
    $paramObj->cancel_date = date('Y-m-d H:i:s');

    $result = $this->repo->cancelInvoiceDetail($paramObj);

    if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
      //if invoice_detail cancellation is successful
      //check if all invoice details are canceled, if yes, update header status to canceled
      $all_details_canceled_flag = $this->repo->checkAllInvoiceDetailsAreCanceledOrNot($invoice_id);


      //start canceling header
      if(isset($all_details_canceled_flag) && $all_details_canceled_flag == true){
          $paramHeaderObj = $this->repo->getObjByID($invoice_id);

          $currentUser = Utility::getCurrentUserID(); //get currently logged in user

          //change to cancel status
          $paramHeaderObj->status = StatusConstance::status_retailer_cancel_value;
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
            $invoice_header->status_text = StatusConstance::status_retailer_cancel_description;
          }
          //for pilot version
          //end status text
        }
      }

      Excel::create('InvoiceReport', function($excel)use($invoices) {
              $excel->sheet('InvoiceReport', function($sheet)use($invoices) {
                  $displayArray = array();
                  foreach($invoices as $invoice){
                      $displayArray[$invoice->id]["Invoice Number"] = $invoice->id;
                      $displayArray[$invoice->id]["Retailshop Name (Eng)"] = $invoice->retailshop_name_eng;
                      $displayArray[$invoice->id]["Order Date"] = $invoice->order_date;
                      $displayArray[$invoice->id]["Delivery Date"] = $invoice->delivery_date;
                      $displayArray[$invoice->id]["Total Amount"] = $invoice->total_payable_amt;
                      $displayArray[$invoice->id]["Status"] = $invoice->status_text;
                  }

                  if(count($displayArray) == 0){
                      $sheet->fromArray($displayArray);
                  }
                  else{
                      $sheet->cells('A1:F1', function($cells) {
                          $cells->setBackground('#F37075');
                          $cells->setFontSize(13);
                      });

                      $sheet->fromArray($displayArray);
                  }
              });
          })
              ->download('xls');
          ob_flush();
          return Redirect();
    }
    else{
      return redirect('backend/unauthorize');
    }
  }
}
