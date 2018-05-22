<?php
namespace App\Api\Invoice;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\Invoice\Invoice;
use App\Backend\InvoiceDetail\InvoiceDetail;
use App\Core\StatusConstance;
use App\Core\Config\ConfigRepository;
use Carbon\Carbon;

/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 11:11 AM
 */

class InvoiceApiRepository implements InvoiceApiRepositoryInterface
{
    public function saveInvoice($invoice,$invoice_id){
      $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $paramObj                       = new Invoice();
            $paramObj->id                   = $invoice_id;
            $paramObj->status               = StatusConstance::status_confirm_value;
            $paramObj->order_date           = $invoice->order_date;
            $paramObj->delivery_date        = $invoice->delivery_date;
            $paramObj->payment_date         = $invoice->payment_date;
            $paramObj->retailer_id          = $invoice->retailer_id;
            $paramObj->brand_owner_id       = $invoice->brand_owner_id;
            $paramObj->retailshop_id        = $invoice->retailshop_id;
            $paramObj->tax_rate             = $invoice->tax_rate;
            $paramObj->total_net_amt        = $invoice->total_net_amt;
            $paramObj->total_discount_amt   = $invoice->total_discount_amt;
            $paramObj->total_net_amt_w_disc = $invoice->total_net_amt_w_disc;
            $paramObj->total_tax_amt        = $invoice->total_tax_amt;
            $paramObj->total_payable_amt    = $invoice->total_payable_amt;
            $paramObj->remark               = $invoice->remark;
            $paramObj->confirm_by           = NULL;
            $paramObj->confirm_date         = NULL;
            $paramObj->cancel_by            = NULL;
            $paramObj->cancel_date          = NULL;
            $paramObj->created_by           = $invoice->created_by;
            $paramObj->updated_by           = $invoice->updated_by;
            $paramObj->deleted_by           = $invoice->deleted_by;
            $paramObj->created_at           = $invoice->created_at;
            $paramObj->updated_at           = $invoice->updated_at;
            $paramObj->deleted_at           = $invoice->deleted_at;
            $paramObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
            return $returnedObj;
        }
    }

    public function saveInvoiceDetail($invDetail,$detail_id,$invoice_id){
      $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {

            DB::table('invoice_detail')->insert([
              'id'                  => $detail_id,
              'invoice_id'          => $invoice_id,
              'product_id'          => $invDetail->product_id,
              'product_group_id'    => $invDetail->product_group_id,
              'status'              => StatusConstance::status_confirm_value,
              'uom_id'              => $invDetail->uom_id,
              'uom'                 => $invDetail->uom,
              'quantity'            => $invDetail->quantity,
              'unit_price'          => $invDetail->unit_price,
              'net_amt'             => $invDetail->net_amt,
              'discount_amt'        => $invDetail->discount_amt,
              'net_amt_w_disc'      => $invDetail->net_amt_w_disc,
              'tax_amt'             => $invDetail->tax_amt,
              'payable_amt'         => $invDetail->payable_amt,
              'remark'              => $invDetail->remark,
              'confirm_by'          => NULL,
              'confirm_date'        => NULL,
              'cancel_by'           => NULL,
              'cancel_date'         => NULL,
            ]);

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
            return $returnedObj;
        }
    }

    public function uploadInvoice($invoices) {
      $returnedObj                          = array();
      $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
      $returnedObj['aceplusStatusMessage']  = "Request is successful!";

      try {
        $configRepo = new ConfigRepository();
        DB::beginTransaction();
        foreach($invoices as $invoice){
          // Save Invoice
          $id_prefix                      = $configRepo->getInvoicePrefixId()[0]->value;
          $date_str                       = date('Ymd',strtotime("now"));
          $prefix                         = $id_prefix.$date_str;
          $table                          = (new Invoice())->getTable();
          $col                            = 'id';
          $offset                         = 1;
          $invoice_id                     = Utility::generate_id($prefix,$table,$col,$offset);
          $invoiceRes                     = $this->saveInvoice($invoice,$invoice_id);
          if($invoiceRes['aceplusStatusCode'] != ReturnMessage::OK){
            DB::rollback();
            $returnedObj['aceplusStatusCode']     = $invoiceRes['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage']  = $invoiceRes['aceplusStatusMessage'];
            return $returnedObj;
          }

          // Delete InvoiceDetail
          $deleteInvoiceDetail              = InvoiceDetail::where('invoice_id',$invoice_id)->delete();

          foreach($invoice->invoice_detail as $invDetail){

            $detail_id                      = uniqid('', true);
            $detailRes                      = $this->saveInvoiceDetail($invDetail,$detail_id,$invoice_id);
            if($detailRes['aceplusStatusCode'] != ReturnMessage::OK){
              DB::rollback();
              $returnedObj['aceplusStatusCode']     = $detailRes['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $detailRes['aceplusStatusMessage'];
              return $returnedObj;
            }
          }

        }
        DB::commit();
        return $returnedObj;
      }
      catch(\Exception $e){
          DB::rollback();
          $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
          $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
          return $returnedObj;
      }
    }

    public function getInvoiceList($retailer_id,$filter) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $query = Invoice::query();
        $query = $query->whereNull('deleted_at');

        // for month filter
        // month_filter may be 1 (previous month) or 3 (previous 3 months) or all
        if(isset($filter) && $filter !== "all"){
          $query = $query->whereMonth('order_date', '=' ,Carbon::now()->subMonth($filter)->month);
        }

        $invoices = $query->get();

        foreach($invoices as $invoice_header){
          dd('header_obj',$invoice_header);
          $invoice_detail_query = InvoiceDetail::query();
          $invoice_detail_query = $invoice_detail_query->where('invoice_id','=',$invoice_header->id); //match with invoice header id
          $invoice_details      = $invoice_detail_query->get();

          $invoice_header->invoice_detail = $invoice_details;
        }
        // dd('inv',$invoices);
        if(isset($invoices) && count($invoices)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['invoices']             = $invoices;
          return $returnedObj;
        }
        else{
          //if date does not exist
          $returnedObj['aceplusStatusMessage']  = "Delivery Date does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
