<?php
namespace App\Api\Invoice;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;

/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 11:11 AM
 */

class InvoiceApiRepository implements InvoiceApiRepositoryInterface
{
    public function saveObj($paramObj){
      $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            $returnedObj['id'] = $tempObj->id;
            return $returnedObj;
        }
        catch(\Exception $e){
            $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
            return $returnedObj;
        }
    }

    public function uploadInvoice($invoices) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
      $returnedObj['aceplusStatusMessage']  = "Request is successful!";

      try {
        DB::beginTransaction();
        foreach($invoices as $invoice){
          $invoice_id                     = uniqid('', true);;
          $paramObj                       = new Invoice();
          $paramObj->id                   = $invoice_id;
          $paramObj->status               = $status;
          $paramObj->order_date           = $invoice->order_date;
          $paramObj->delivery_date        = $invoice->delivery_date;
          $paramObj->payment_date         = $invoice->payment_date;
          $paramObj->retailer_id          = $invoice->retailer_id;
          $paramObj->brand_owner_id       = $invoice->brand_owner_id;
          $paramObj->retailshop_id        = $invoice->retailshop_id;
          $paramObj->tax_rate             = $invoice->tax_rate;
          $paramObj->total_net_amt        = $invoice->total_net_amt;
          $paramObj->total_discount_amt   = $invoice->total_discount_amt;
          $paramObj->total_net_amt_w_dis  = $invoice->total_net_amt_w_dis;
          $paramObj->total_tax_amt        = $invoice->total_tax_amt;
          $paramObj->total_payable_amt    = $invoice->total_payable_amt;
          $paramObj->remark               = $invoice->remark;
          $paramObj->created_by           = $invoice->created_by;
          $paramObj->updated_by           = $invoice->updated_by;
          $paramObj->deleted_by           = $invoice->deleted_by;
          $paramObj->created_at           = $invoice->created_at;
          $paramObj->updated_at           = $invoice->updated_at;
          $paramObj->deleted_at           = $invoice->deleted_at;

          $invoiceRes                     = $this->saveObj($paramObj);
          if($invoiceRes['aceplusStatusCode'] != ReturnMessage::OK){
            DB::rollback();
            $returnedObj['aceplusStatusCode']     = $invoiceRes['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage']  = $invoiceRes['aceplusStatusMessage'];
            return $returnedObj;
          }

          foreach($invoice->invoice_detail as $invDetail){
            $detailObj                      = new InvoiceDetail();
            $detailObj->id                  = uniqid('', true);
            $detailObj->invoice_id          = $invDetail->
          }


        }
        DB::commit();

        if(isset($delivery_date) && count($delivery_date)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['resultObj']             = $delivery_date;
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
