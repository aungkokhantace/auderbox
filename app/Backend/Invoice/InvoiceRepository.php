<?php
namespace App\Backend\Invoice;

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
use Auth;
use App\Log\LogCustom;
use App\Core\CoreConstance;


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

        // get retailshop info too
        $query = $query->select('invoices.*',
                                'retailshops.name_eng as retailshop_name_eng',
                                'retailshops.name_mm as retailshop_name_mm',
                                'retailers.name_eng as retailer_name_eng',
                                'retailers.name_mm as retailer_name_mm',
                                'retailers.phone as retailer_phone',
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
        else if($invoice->status == StatusConstance::status_deliver_value) {
          $invoice->status_text = StatusConstance::status_deliver_description;
        }
        else if($invoice->status == StatusConstance::status_retailer_cancel_value){
          $invoice->status_text = StatusConstance::status_retailer_cancel_description;
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
          if($invoice_detail->status == StatusConstance::status_confirm_value){
            $invoice_detail->status_text = StatusConstance::status_confirm_description;
          }
          else if($invoice_detail->status == StatusConstance::status_deliver_value){
            $invoice_detail->status_text = StatusConstance::status_deliver_description;
          }
          else if($invoice_detail->status == StatusConstance::status_retailer_cancel_value){
            $invoice_detail->status_text = StatusConstance::status_retailer_cancel_description;
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

    public function deliver($paramObj){
      if (Auth::guard('User')->check()) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            DB::beginTransaction();
            $tempObj = Utility::addUpdatedBy($paramObj);

            if($tempObj->save()){
                //create info log
                $date = $tempObj->updated_at;
                $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' delivered invoice_id = '.$tempObj->id . PHP_EOL;
                LogCustom::create($date,$message);

                //update invoice_detail status
                $invoice_id = $paramObj->id;
                $invoice_details = $this->getInvoiceDetailsByInvoiceId($invoice_id);

                //deliver each invoice detail
                foreach($invoice_details as $invoice_detail){
                    //set status to delivered
                    $invoice_detail->status = StatusConstance::status_deliver_value;

                    $invoice_detail_result = $this->deliverInvoiceDetail($invoice_detail);

                    if($invoice_detail_result['aceplusStatusCode'] !== ReturnMessage::OK){
                      $returnedObj['aceplusStatusMessage'] = "Error in delivering invoice_detail";
                      DB::rollBack();
                      return $returnedObj;
                    }
                }

                //all updates are successful
                DB::commit();

                $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                $returnedObj['aceplusStatusMessage'] = "Invoice and invoice detail delivered";
                return $returnedObj;


            }
            else{
                DB::rollBack();
                return $returnedObj;
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
      return redirect('/');
    }

    public function getObjByID($id){
        $result = Invoice::find($id);
        return $result;
    }

    public function getInvoiceDetailsByInvoiceId($invoice_id){
      $invoice_details = InvoiceDetail::get()
                                      ->where('invoice_id',$invoice_id);
      return $invoice_details;
    }

    public function deliverInvoiceDetail($paramDetailObj){
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      $currentUser = Utility::getCurrentUserID(); //get currently logged in user

      try {
        DB::beginTransaction();

        $tempObj = Utility::addUpdatedBy($paramDetailObj);
        $tempObj->save();

        DB::commit();

        //create info log
        $date = $tempObj->updated_at;
        $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' delivered invoice_detail_id = '.$tempObj->id . PHP_EOL;
        LogCustom::create($date,$message);

        $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage'] = "Invoice detail delivered";
        return $returnedObj;
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

    public function cancel($paramObj){
      if (Auth::guard('User')->check()) {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        $currentUser = Utility::getCurrentUserID(); //get currently logged in user

        try {
            $configRepo = new ConfigRepository();

            DB::beginTransaction();
            $tempObj = Utility::addUpdatedBy($paramObj);

            if($tempObj->save()){
                //create info log
                $date = $tempObj->updated_at;
                $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' canceled whole invoice_id = '.$tempObj->id . PHP_EOL;
                LogCustom::create($date,$message);

                //update invoice_detail status
                $invoice_id = $paramObj->id;
                $invoice_details = $this->getInvoiceDetailsByInvoiceId($invoice_id);

                //cancel each invoice detail
                foreach($invoice_details as $invoice_detail){
                    //set status to cancel
                    $invoice_detail->status = StatusConstance::status_retailer_cancel_value;
                    $invoice_detail->cancel_by = $tempObj->cancel_by;
                    $invoice_detail->cancel_date = $tempObj->cancel_date;

                    $invoice_detail_result = $this->cancelInvoiceDetail($invoice_detail);

                    if($invoice_detail_result['aceplusStatusCode'] !== ReturnMessage::OK){
                      $returnedObj['aceplusStatusMessage'] = "Error in canceling invoice_detail";
                      DB::rollBack();
                      return $returnedObj;
                    }

                    $detail_id = $invoice_detail->id;
                    //invoice_detail cancel is successful
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
                    $invDetailHistoryObj->qty = -1 * abs($invoice_detail->quantity); //negative value, because of cancel action
                    $invDetailHistoryObj->date = date('Y-m-d H:i:s');
                    $invDetailHistoryObj->type = CoreConstance::invoice_detatil_order_value; //invoice_history_type is "order"
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

                //all updates are successful
                DB::commit();

                $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                $returnedObj['aceplusStatusMessage'] = "Invoice and invoice detail canceled";
                return $returnedObj;


            }
            else{
                DB::rollBack();
                return $returnedObj;
            }
        }
        catch(\Exception $e){
            DB::rollBack();

            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' canceled an invoice and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            LogCustom::create($date,$message);

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
      }
      return redirect('/');
    }

    public function cancelInvoiceDetail($paramDetailObj){
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      $currentUser = Utility::getCurrentUserID(); //get currently logged in user

      try {
        DB::beginTransaction();

        $tempObj = Utility::addUpdatedBy($paramDetailObj);
        $tempObj->save();

        DB::commit();

        //create info log
        $date = $tempObj->updated_at;
        $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' canceled invoice_detail_id = '.$tempObj->id . PHP_EOL;
        LogCustom::create($date,$message);

        $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage'] = "Invoice detail canceled";
        return $returnedObj;
      }
      catch(\Exception $e){
        DB::rollBack();
        //create error log
        $date    = date("Y-m-d H:i:s");
        $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' canceled an invoice and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
        LogCustom::create($date,$message);

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

    public function getInvoiceDetailByID($id){
        $result = InvoiceDetail::find($id);
        return $result;
    }

    public function checkAllInvoiceDetailsAreCanceledOrNot($invoice_id){
      $all_canceled_flag = true;
      $cancel_status_array = [StatusConstance::status_retailer_cancel_value,
                              StatusConstance::status_brand_owner_cancel_value,
                              StatusConstance::status_auderbox_cancel_value];

      $invoice_details = InvoiceDetail::where('invoice_id',$invoice_id)
                                      // ->whereIn('status',$cancel_status_array)
                                      ->whereNull('deleted_at')
                                      ->get();

      foreach($invoice_details as $invoice_detail){
        if(!(in_array($invoice_detail->status,$cancel_status_array))) {
          $all_canceled_flag = false;
        }
      }

      return $all_canceled_flag;
    }

    public function updateHeaderPrice($paramHeaderObj) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
      try{
        $tempObj = Utility::addUpdatedBy($paramHeaderObj);
        $tempObj->save();

        $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage'] = "Invoice header price is successfully updated!";

        return $returnedObj;
      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
          return $returnedObj;
      }
    }
}
