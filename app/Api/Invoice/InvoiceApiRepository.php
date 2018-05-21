<?php
namespace App\Api\Invoice;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\Invoice\Invoice;
use App\Backend\InvoiceDetail\InvoiceDetail;
use App\Core\StatusConstance;

/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 11:11 AM
 */

class InvoiceApiRepository implements InvoiceApiRepositoryInterface
{
    public function saveInvoice($invoice,$invoice_id){
      // dd('save invoice',$invoice->order_date);
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

            $detailObj                      = new InvoiceDetail();
            $detailObj->id                  = $detail_id;
            $detailObj->invoice_id          = $invoice_id;
            $detailObj->product_id          = $invDetail->product_id;
            $detailObj->product_group_id    = $invDetail->product_group_id;
            $detailObj->status              = StatusConstance::status_confirm_value;
            $detailObj->uom_id              = $invDetail->uom_id;
            $detailObj->uom                 = $invDetail->uom;
            $detailObj->quantity            = $invDetail->quantity;
            $detailObj->unit_price          = $invDetail->unit_price;
            $detailObj->net_amt             = $invDetail->net_amt;
            $detailObj->discount_amt        = $invDetail->discount_amt;
            $detailObj->net_amt_w_disc      = $invDetail->net_amt_w_disc;
            $detailObj->tax_amt             = $invDetail->tax_amt;
            $detailObj->payable_amt         = $invDetail->payable_amt;
            $detailObj->remark              = $invDetail->remark;
            $detailObj->save();

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
          // Save Invoice
          $invoice_id                     = uniqid('', true);;
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
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
