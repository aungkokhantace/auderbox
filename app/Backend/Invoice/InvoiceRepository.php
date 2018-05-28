<?php
namespace App\Backend\Invoice;

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
 * Author: Aung Ko Khant
 * Date: 2018-05-24
 * Time: 02:14 PM
 */

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getInvoiceList($from_date = null,$to_date = null,$status = null) {
      try {
          if(isset($from_date) && count($from_date) > 0){
            $formatted_from_date = date("Y-m-d", strtotime($from_date));
          }
          if(isset($to_date) && count($to_date) > 0){
            $formatted_to_date = date("Y-m-d", strtotime($to_date));
          }
          //start query
          $query = Invoice::query();

          // get retailshop info too
          $query = $query->select('invoices.*',
                                  'retailshops.name_eng as retailshop_name_eng',
                                  'retailshops.name_mm as retailshop_name_mm');


          // //get only invoice info (not retailshop info)
          // $query = $query->select('invoices.*');

          $query = $query->leftJoin('retailers', 'retailers.id', '=', 'invoices.retailer_id');
          $query = $query->leftJoin('brand_owners', 'brand_owners.id', '=', 'invoices.brand_owner_id');
          $query = $query->leftJoin('retailshops', 'retailshops.id', '=', 'invoices.retailshop_id');

          if(isset($formatted_from_date) && count($formatted_from_date) > 0){
            $query = $query->where('invoices.order_date','>=',$formatted_from_date);
          }
          if(isset($formatted_to_date) && count($formatted_to_date) > 0){
            $query = $query->where('invoices.order_date','<=',$formatted_to_date);
          }
          if(isset($status) && $status !== 0 && $status !== "all"){
            $query = $query->where('invoices.status','=',$status);
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
          //end query

          return $invoices;
      }
      catch(\Exception $e){
          return $e->getMessage();
      }
    }

    public function getInvoiceDetail($invoice_id) {
      try {
        //start query to get invoice header
        $query = Invoice::query();

        // // get retailshop info too
        // $query = $query->select('invoices.id as id',
        //                         'invoices.order_date as order_date',
        //                         'invoices.delivery_date as delivery_date',
        //                         'invoices.payment_date as payment_date',
        //                         'retailshops.name_eng as retailshop_name_eng',
        //                         'retailshops.name_mm as retailshop_name_mm',
        //                         'retailers.name_eng as retailer_name_eng',
        //                         'retailers.name_mm as retailer_name_mm',
        //                         'retailshops.address as retailshop_address');

        // get retailshop info too
        $query = $query->select('invoices.*',
                                'retailshops.name_eng as retailshop_name_eng',
                                'retailshops.name_mm as retailshop_name_mm',
                                'retailers.name_eng as retailer_name_eng',
                                'retailers.name_mm as retailer_name_mm',
                                'retailshops.address as retailshop_address');


        $query = $query->leftJoin('retailers', 'retailers.id', '=', 'invoices.retailer_id');
        $query = $query->leftJoin('brand_owners', 'brand_owners.id', '=', 'invoices.brand_owner_id');
        $query = $query->leftJoin('retailshops', 'retailshops.id', '=', 'invoices.retailshop_id');

        //get records that are not deleted
        $query = $query->whereNull('invoices.deleted_at');
        $query = $query->whereNull('retailers.deleted_at');
        $query = $query->whereNull('brand_owners.deleted_at');
        $query = $query->whereNull('retailshops.deleted_at');

        //get status = active records
        $query = $query->where('retailers.status',1);
        $query = $query->where('brand_owners.status',1);
        $query = $query->where('retailshops.status',1);

        $query = $query->where('invoices.id',$invoice_id);

        $invoice = $query->first();
        //end query to get invoice header

        /*
        //all status
        //get status text according to status (integer)
        if($invoice->status == StatusConstance::status_pending_value){
          $invoice->status_text = StatusConstance::status_pending_description;
        }
        else if($invoice->status == StatusConstance::status_confirm_value){
          $invoice->status_text = StatusConstance::status_confirm_description;
        }
        else if($invoice->status == StatusConstance::status_deliver_value){
          $invoice->status_text = StatusConstance::status_deliver_description;
        }
        else if($invoice->status == StatusConstance::status_retailer_cancel_value){
          $invoice->status_text = StatusConstance::status_retailer_cancel_description;
        }
        else if($invoice->status == StatusConstance::status_brand_owner_cancel_value){
          $invoice->status_text = StatusConstance::status_brand_owner_cancel_description;
        }
        else{
          $invoice->status_text = StatusConstance::status_auderbox_cancel_description;
        }
        */

        //for pilot version
        if($invoice->status == StatusConstance::status_confirm_value){
          $invoice->status_text = StatusConstance::status_confirm_description;
        }
        else {
          $invoice->status_text = StatusConstance::status_deliver_description;
        }
        //for pilot version

        // start invoice_detail data
        //get invoice detail info
        $invoice_detail_query = InvoiceDetail::query();

        $invoice_detail_query = $invoice_detail_query->select('invoice_detail.*',
                                                              'product_group.name as product_name',
                                                              'product_uom_type.name_eng as product_uom_type_name_eng',
                                                              'product_uom_type.name_mm as product_uom_type_name_mm',
                                                              'product_uom_type.total_quantity as total_uom_quantity',
                                                              'product_volume_type.name as product_volume_type_name',
                                                              'product_container_type.name as product_container_type_name',
                                                              'brand_owners.name as brand_owner_name',
                                                              'products.sku as sku');

        $invoice_detail_query = $invoice_detail_query->leftJoin('products', 'products.id', '=', 'invoice_detail.product_id');
        $invoice_detail_query = $invoice_detail_query->leftJoin('product_group', 'product_group.id', '=', 'products.product_group_id');
        $invoice_detail_query = $invoice_detail_query->leftJoin('product_uom_type', 'product_uom_type.id', '=', 'products.product_uom_type_id');
        $invoice_detail_query = $invoice_detail_query->leftJoin('product_volume_type', 'product_volume_type.id', '=', 'product_group.product_volume_type_id');
        $invoice_detail_query = $invoice_detail_query->leftJoin('product_container_type', 'product_container_type.id', '=', 'product_group.product_container_type_id');
        $invoice_detail_query = $invoice_detail_query->leftJoin('brand_owners', 'brand_owners.id', '=', 'product_group.brand_owner_id');

        $invoice_detail_query = $invoice_detail_query->where('invoice_id','=',$invoice->id); //match with invoice header id
        $invoice_details      = $invoice_detail_query->get();

        //loop through each invoice detail to get status_text of each invoice_detail
        foreach($invoice_details as $invoice_detail){
          /*
          //all status
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
          */

          //for pilot version
          $invoice_detail->status_text = StatusConstance::status_confirm_description;
          if($invoice_detail->status == StatusConstance::status_confirm_value){
          }
          else {
            $invoice_detail->status_text = StatusConstance::status_deliver_description;
          }
          //for pilot version
        }

        $invoice->invoice_details = $invoice_details;
        //end invoice_detail data

        return $invoice;
      }
      catch(\Exception $e){
          return $e->getMessage();
      }
    }
}
