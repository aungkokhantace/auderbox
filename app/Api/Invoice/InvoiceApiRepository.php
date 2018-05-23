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
use App\Backend\Retailshop\Retailshop;

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
            $paramObj->created_by           = (isset($invoice->created_by) && $invoice->created_by != "") ? $invoice->created_by:null;
            $paramObj->updated_by           = (isset($invoice->updated_by) && $invoice->updated_by != "") ? $invoice->updated_by:null;
            $paramObj->deleted_by           = (isset($invoice->deleted_by) && $invoice->deleted_by != "") ? $invoice->deleted_by:null;
            $paramObj->created_at           = (isset($invoice->created_at) && $invoice->created_at != "") ? $invoice->created_at:null;
            $paramObj->updated_at           = (isset($invoice->updated_at) && $invoice->updated_at != "") ? $invoice->updated_at:null;
            $paramObj->deleted_at           = (isset($invoice->deleted_at) && $invoice->deleted_at != "") ? $invoice->deleted_at:null;

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
        $query = $query->select('invoices.*',
                                'retailshops.name_eng as retailshop_name_eng',
                                'retailshops.name_mm as retailshop_name_mm',
                                'retailshops.address as retailshop_address');

        $query = $query->leftJoin('retailers', 'retailers.id', '=', 'invoices.retailer_id');
        $query = $query->leftJoin('brand_owners', 'brand_owners.id', '=', 'invoices.brand_owner_id');
        $query = $query->leftJoin('retailshops', 'retailshops.id', '=', 'invoices.retailshop_id');


        // month_filter may be 1 (previous month) or 3 (previous 3 months) or all
        if(isset($filter) && $filter !== "all"){
          $query = $query->whereMonth('invoices.order_date', '=' ,Carbon::now()->subMonth($filter)->month);
        }

        //get records that are not deleted
        $query = $query->whereNull('invoices.deleted_at');
        $query = $query->whereNull('retailers.deleted_at');
        $query = $query->whereNull('brand_owners.deleted_at');
        $query = $query->whereNull('retailshops.deleted_at');

        //get status = active records
        $query = $query->where('retailers.status',1);
        $query = $query->where('brand_owners.status',1);
        $query = $query->where('retailshops.status',1);

        $invoices = $query->get();

        foreach($invoices as $invoice_header){
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

          //get invoice detail info
          $invoice_detail_query = InvoiceDetail::query();

          $invoice_detail_query = $invoice_detail_query->select('invoice_detail.*',
                                                                'product_group.name as product_name',
                                                                'product_uom_type.name_eng as product_uom_type_name_eng',
                                                                'product_uom_type.name_mm as product_uom_type_name_mm',
                                                                'product_uom_type.total_quantity as total_uom_quantity',
                                                                'product_volume_type.name as product_volume_type_name',
                                                                'product_container_type.name as product_container_type_name');

          $invoice_detail_query = $invoice_detail_query->leftJoin('products', 'products.id', '=', 'invoice_detail.product_id');
          $invoice_detail_query = $invoice_detail_query->leftJoin('product_group', 'product_group.id', '=', 'products.product_group_id');
          $invoice_detail_query = $invoice_detail_query->leftJoin('product_uom_type', 'product_uom_type.id', '=', 'products.product_uom_type_id');
          $invoice_detail_query = $invoice_detail_query->leftJoin('product_volume_type', 'product_volume_type.id', '=', 'product_group.product_volume_type_id');
          $invoice_detail_query = $invoice_detail_query->leftJoin('product_container_type', 'product_container_type.id', '=', 'product_group.product_container_type_id');

          $invoice_detail_query = $invoice_detail_query->where('invoice_id','=',$invoice_header->id); //match with invoice header id
          $invoice_details      = $invoice_detail_query->get();

          //loop through each invoice detail to get status_text of each invoice_detail
          foreach($invoice_details as $invoice_detail){
            //get status text according to status (integer)
            if($invoice_detail->status == StatusConstance::status_pending_value){
              $invoice_detail->status_text = StatusConstance::status_pending_description;
            }
            else if($invoice_detail->status == StatusConstance::status_confirm_value){
              $invoice_detail->status_text = StatusConstance::status_confirm_description;
            }
            else if($invoice_detail->status == StatusConstance::status_deliver_value){
              $invoice_detail->status_text = StatusConstance::status_deliver_description;
            }
            else if($invoice_detail->status == StatusConstance::status_retailer_cancel_value){
              $invoice_detail->status_text = StatusConstance::status_retailer_cancel_description;
            }
            else if($invoice_detail->status == StatusConstance::status_brand_owner_cancel_value){
              $invoice_detail->status_text = StatusConstance::status_brand_owner_cancel_description;
            }
            else{
              $invoice_detail->status_text = StatusConstance::status_auderbox_cancel_description;
            }
          }

          $invoice_header->invoice_detail = $invoice_details;
        }

        if(isset($invoices) && count($invoices)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['invoices']             = $invoices;
          return $returnedObj;
        }
        else{
          //if obj does not exist
          $returnedObj['aceplusStatusMessage']  = "Invoice does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
