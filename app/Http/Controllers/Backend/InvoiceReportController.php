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
          else{
            $invoice_header->status_text = StatusConstance::status_deliver_description;
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

    //change to cancel status
    $paramObj->status = StatusConstance::status_retailer_cancel_value;

    $result = $this->repo->cancel($paramObj);
    
    if ($result['aceplusStatusCode'] == ReturnMessage::OK) {
      return redirect()->action('Backend\InvoiceReportController@index')
          ->withMessage(FormatGenerator::message('Success', 'Invoice canceled ...'));
    } else {
      return redirect()->action('Backend\InvoiceReportController@index')
          ->withMessage(FormatGenerator::message('Fail', 'Invoice is not canceled ...'));
    }
  }
}
