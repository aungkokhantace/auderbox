<?php
namespace App\Api\Invoice;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\Invoice\Invoice;
use App\Backend\InvoiceDetail\InvoiceDetail;
use App\Backend\InvoiceDetailHistory\InvoiceDetailHistory;
use App\Core\StatusConstance;
use App\Core\Config\ConfigRepository;
use Carbon\Carbon;
use App\Backend\Retailshop\Retailshop;
use App\Core\CoreConstance;
use App\Backend\InvoiceSession\InvoiceSession;

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
            $paramObj->order_date           = date('Y-m-d',strtotime($invoice->order_date));
            $paramObj->delivery_date        = date('Y-m-d',strtotime($invoice->delivery_date));
            $paramObj->payment_date         = date('Y-m-d',strtotime($invoice->payment_date));
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
            $paramObj->created_at           = (isset($invoice->created_at) && $invoice->created_at != "") ? date('Y-m-d',strtotime($invoice->created_at)):null;
            $paramObj->updated_at           = (isset($invoice->updated_at) && $invoice->updated_at != "") ? date('Y-m-d',strtotime($invoice->updated_at)):null;
            $paramObj->deleted_at           = (isset($invoice->deleted_at) && $invoice->deleted_at != "") ? date('Y-m-d',strtotime($invoice->deleted_at)):null;

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
              'created_by'          => (isset($invDetail->created_by) && $invDetail->created_by != "") ? $invDetail->created_by:null,
              'updated_by'          => (isset($invDetail->updated_by) && $invDetail->updated_by != "") ? $invDetail->updated_by:null,
              'deleted_by'          => (isset($invDetail->deleted_by) && $invDetail->deleted_by != "") ? $invDetail->deleted_by:null,
              'created_at'          => (isset($invDetail->created_at) && $invDetail->created_at != "") ? $invDetail->created_at:null,
              'updated_at'          => (isset($invDetail->updated_at) && $invDetail->updated_at != "") ? $invDetail->updated_at:null,
              'deleted_at'          => (isset($invDetail->deleted_at) && $invDetail->deleted_at != "") ? $invDetail->deleted_at:null,
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
          $pad_length                     = $configRepo->getInvoiceIdPadLength()[0]->value; //number of digits without prefix and date
          // $invoice_id                     = Utility::generate_id($prefix,$table,$col,$offset);
          $invoice_id                     = Utility::generate_id($prefix,$table,$col,$offset,$pad_length);
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
            // $detail_id                      = uniqid('', true);
            //start generating invoice_detail_id
            $invoice_detail_table           = (new InvoiceDetail())->getTable();
            $invoice_detail_col             = 'id';
            $invoie_detail_offset           = 1;
            $invoice_detail_pad_length      = $configRepo->getInvoiceDetailIdPadLength()[0]->value; //number of digits without prefix and date
            $detail_id                      = Utility::generate_id($invoice_id,$invoice_detail_table,$invoice_detail_col,$invoie_detail_offset,$invoice_detail_pad_length);
            //end generating invoice_detail_id

            $detailRes                      = $this->saveInvoiceDetail($invDetail,$detail_id,$invoice_id);

            if($detailRes['aceplusStatusCode'] != ReturnMessage::OK){
              DB::rollback();
              $returnedObj['aceplusStatusCode']     = $detailRes['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $detailRes['aceplusStatusMessage'];
              return $returnedObj;
            }

            //start invoice_detail_history
            //start generating invoice_detail_history_id
            $invoice_detail_history_table      = (new InvoiceDetailHistory())->getTable();
            $invoice_detail_history_col        = 'id';
            $invoie_detail_history_offset      = 1;
            $invoice_detail_history_pad_length = $configRepo->getInvoiceDetailIdPadLength()[0]->value; //number of digits without prefix and date
            $detail_history_id                 = Utility::generate_id($detail_id,$invoice_detail_history_table,$invoice_detail_history_col,$invoie_detail_history_offset,$invoice_detail_history_pad_length);
            //end generating invoice_detail_history_id

            $invDetailHistoryObj = new InvoiceDetailHistory();
            $invDetailHistoryObj->id = $detail_history_id;
            $invDetailHistoryObj->invoice_detail_id = $detail_id;
            $invDetailHistoryObj->qty = $invDetail->quantity;
            $invDetailHistoryObj->date = date('Y-m-d H:i:s');
            $invDetailHistoryObj->type = CoreConstance::invoice_detail_order_value; //invoice_history_type is "order"
            $invDetailHistoryObj->status = 1; //default is active

            $detailHistoryRes = $this->saveInvoiceDetailHistory($invDetailHistoryObj);

            if($detailHistoryRes['aceplusStatusCode'] != ReturnMessage::OK){
              DB::rollback();
              $returnedObj['aceplusStatusCode']     = $detailHistoryRes['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $detailHistoryRes['aceplusStatusMessage'];
              return $returnedObj;
            }
            //end invoice_detail_history
          }
        }

        DB::commit();
        $returnedObj['invoice_id'] = $invoice_id;
        return $returnedObj;
      }
      catch(\Exception $e){
          DB::rollback();
          $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
          $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
          return $returnedObj;
      }
    }

    public function getInvoiceDetail($invoice_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $query = Invoice::query();

        // get retailshop info too
        // $query = $query->select('invoices.id as id',
        //                         'invoices.order_date as order_date',
        //                         'invoices.delivery_date as delivery_date',
        //                         'invoices.total_payable_amt as total_payable_amt',
        //                         'retailshops.name_eng as retailshop_name_eng',
        //                         'retailshops.name_mm as retailshop_name_mm',
        //                         'retailshops.address as retailshop_address');

        $query = $query->select('invoices.*',
                                'retailshops.name_eng as retailshop_name_eng',
                                'retailshops.name_mm as retailshop_name_mm',
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

        /*
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
        else if($invoice->status == StatusConstance::status_deliver_value){
          $invoice->status_text = StatusConstance::status_deliver_description;
        }
        else{
          $invoice->status_text = StatusConstance::status_auderbox_cancel_description;
        }
        //for pilot
        //for pilot version

        //change date format to d-m-Y
        $invoice->order_date = date('d-m-Y',strtotime($invoice->order_date));
        $invoice->delivery_date = date('d-m-Y',strtotime($invoice->delivery_date));
        $invoice->payment_date = date('d-m-Y',strtotime($invoice->payment_date));
        $invoice->confirm_date = date('d-m-Y',strtotime($invoice->confirm_date));
        $invoice->cancel_date = date('d-m-Y',strtotime($invoice->cancel_date));

        // //start changing date objects to string
        // $invoice->order_date = $invoice->order_date->toDateString();
        // $invoice->delivery_date = $invoice->delivery_date->toDateString();
        // $invoice->payment_date = $invoice->payment_date->toDateString();
        // //end changing date objects to string

        // start invoice_detail data
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

        $invoice_detail_query = $invoice_detail_query->where('invoice_id','=',$invoice->id); //match with invoice header id
        $invoice_details      = $invoice_detail_query->get();

        //loop through each invoice detail to get status_text of each invoice_detail
        foreach($invoice_details as $invoice_detail){
          /*
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
          if($invoice_detail->status == StatusConstance::status_confirm_value){
            $invoice_detail->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_detail->status == StatusConstance::status_deliver_value){
            $invoice_detail->status_text = StatusConstance::status_deliver_description;
          }
          else{
            $invoice_detail->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          //for pilot version
        }

        $invoice->invoice_detail = $invoice_details;
        //end invoice_detail data

        if(isset($invoice) && count($invoice)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['invoices']              = $invoice;
          return $returnedObj;
        }
        else{
          //if obj does not exist
          $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Invoice does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }

    public function getInvoiceList($retailer_id,$filter) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $query = Invoice::query();
        /*
        // get retailshop info too
        $query = $query->select('invoices.*',
                                'retailshops.name_eng as retailshop_name_eng',
                                'retailshops.name_mm as retailshop_name_mm',
                                'retailshops.address as retailshop_address');
        */

        //get only invoice info (not retailshop info)
        $query = $query->select('invoices.*');

        $query = $query->leftJoin('retailers', 'retailers.id', '=', 'invoices.retailer_id');
        $query = $query->leftJoin('brand_owners', 'brand_owners.id', '=', 'invoices.brand_owner_id');
        $query = $query->leftJoin('retailshops', 'retailshops.id', '=', 'invoices.retailshop_id');


        // month_filter may be 1 (previous month) or 3 (previous 3 months) or 0 (all invoices)
        if(isset($filter) && $filter !== 0){
          // $query = $query->whereMonth('invoices.order_date', '=' ,Carbon::now()->subMonth($filter)->month);
          $query = $query->where('invoices.order_date', '>' ,Carbon::now()->subDays($filter));
        }

        if(isset($retailer_id) && $retailer_id !== 0){
          // $query = $query->whereMonth('invoices.order_date', '=' ,Carbon::now()->subMonth($filter)->month);
          $query = $query->where('invoices.retailer_id' ,$retailer_id);
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
          /*
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

          //for pilot
          if($invoice_header->status == StatusConstance::status_confirm_value){
            $invoice_header->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_header->status == StatusConstance::status_deliver_value){
            $invoice_header->status_text = StatusConstance::status_deliver_description;
          }
          else{
            $invoice_header->status_text = StatusConstance::status_auderbox_cancel_description;
          }
          //for pilot
          //change date format to d-m-Y
          $invoice_header->order_date = date('d-m-Y',strtotime($invoice_header->order_date));
          $invoice_header->delivery_date = date('d-m-Y',strtotime($invoice_header->delivery_date));
          $invoice_header->payment_date = date('d-m-Y',strtotime($invoice_header->payment_date));
          $invoice_header->confirm_date = date('d-m-Y',strtotime($invoice_header->confirm_date));
          $invoice_header->cancel_date = date('d-m-Y',strtotime($invoice_header->cancel_date));

          /*
          // start invoice_detail data
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
          */
          //end invoice_detail data
        }

        if(isset($invoices) && count($invoices)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['invoices']              = $invoices;
          return $returnedObj;
        }
        else{
          //if obj does not exist
          $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Invoice does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }

    public function saveInvoiceDetailHistory($paramObj)
    {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
      try{
        $tempObj = Utility::addCreatedBy($paramObj);
        $tempObj->save();

        $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage'] = "Invoice detail history is successfully saved!";

        return $returnedObj;
      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
          return $returnedObj;
      }
    }

    public function addToCart($paramObj)
    {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try{
        DB::beginTransaction();

        //declare config repository
        $configRepo         = new ConfigRepository();
        $current_date_time  = date('Y-m-d H:i:s');
        $current_date       = date('Y-m-d');

        $retailer_id    = $paramObj->retailer_id;
        $retailshop_id  = $paramObj->retailshop_id;
        $brand_owner_id = $paramObj->brand_owner_id;
        $product_id     = $paramObj->product_id;
        $quantity       = $paramObj->quantity;
        $created_date   = $current_date_time;

        //start checking whether the product is already in cart list
        $existing_product = DB::table('invoice_session')
                                ->where('retailer_id',$retailer_id)
                                ->where('retailshop_id',$retailshop_id)
                                ->where('product_id',$product_id)
                                ->whereDate('created_date','=',$current_date) //check records with today date
                                ->first();
        //end checking whether the product is already in cart list

        //if the product is already in cart list, just update the quantity (increase quantity)
        if(isset($existing_product) && count($existing_product) > 0) {
          $old_quantity       = $existing_product->quantity;  //original qty
          $add_more_quantity  = $quantity;  //newly added qty
          $new_quantity       = $old_quantity + $add_more_quantity; //calculate new qty

          //update quantity (add more quantity)
          DB::table('invoice_session')
            ->where('product_id', $product_id)
            ->update(['quantity' => $new_quantity]);
        }
        //if the product doesn't exist in cart list yet, then, create new record in invoice_session table
        else{
          //generate id for invoice_session table
          $date_str                       = date('Ymd',strtotime("now"));
          $prefix                         = $date_str;
          $table                          = (new InvoiceSession())->getTable();
          $col                            = 'id';
          $offset                         = 1;
          $pad_length                     = $configRepo->getInvoiceSessionIdPadLength()[0]->value; //number of digits without prefix and date
          $invoice_session_id = Utility::generate_id($prefix,$table,$col,$offset, $pad_length = 6);

          //insert into db
          DB::table('invoice_session')->insert([
            'id'              => $invoice_session_id,
            'retailer_id'     => $retailer_id,
            'retailshop_id'   => $retailshop_id,
            'brand_owner_id'  => $brand_owner_id,
            'product_id'      => $product_id,
            'quantity'        => $quantity,
            'created_date'    => $created_date,
          ]);
        }

        DB::commit();

        $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage'] = "Cart data is successfully saved!";

        return $returnedObj;
      }
      catch(\Exception $e){
        DB::rollback();
        $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
        return $returnedObj;
      }
    }

    public function updateCartQty($paramObj)
    {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try{
        DB::beginTransaction();

        //declare config repository
        $configRepo         = new ConfigRepository();
        $current_date_time  = date('Y-m-d H:i:s');
        $current_date       = date('Y-m-d');

        $retailer_id    = $paramObj->retailer_id;
        $retailshop_id  = $paramObj->retailshop_id;
        $brand_owner_id = $paramObj->brand_owner_id;
        $product_id     = $paramObj->product_id;
        $quantity       = $paramObj->quantity;
        $created_date   = $current_date_time;

        //check whether new_qty is 0 or not
        //if 0, delete that product from cart list
        if($quantity == 0){
          DB::table('invoice_session')
                  ->where('product_id',$product_id)
                  ->delete();

          DB::commit();

          $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage'] = "Product is successfully removed from cart !";
          return $returnedObj;
        }
        else{
          //start checking whether the product is already in cart list
          $existing_product = DB::table('invoice_session')
                                  ->where('retailer_id',$retailer_id)
                                  ->where('retailshop_id',$retailshop_id)
                                  ->where('product_id',$product_id)
                                  ->whereDate('created_date','=',$current_date) //check records with today date
                                  ->first();
          //end checking whether the product is already in cart list

          //if the product is already in cart list, just update the quantity (not adding, just updating with new qty from api request)
          if(isset($existing_product) && count($existing_product) > 0) {

          //update quantity (not adding, just updating with new qty from api request)
          DB::table('invoice_session')
            ->where('product_id', $product_id)
            ->update(['quantity' => $quantity]);
          }
          //if the product doesn't exist in cart list
          else{
            DB::rollback();
            $returnedObj['aceplusStatusMessage'] = "The product does not exist in cart list !";
            return $returnedObj;
          }

          DB::commit();

          $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage'] = "Cart data is successfully saved!";
          return $returnedObj;
        }
      }
      catch(\Exception $e){
        DB::rollback();
        $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
        return $returnedObj;
      }
    }
}
