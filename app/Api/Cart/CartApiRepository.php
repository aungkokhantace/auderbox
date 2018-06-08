<?php
namespace App\Api\Cart;

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
 * Author: Aung Ko Khant
 * Date: 2018-06-08
 * Time: 01:21 PM
 */

class CartApiRepository implements CartApiRepositoryInterface
{
    public function addToCart($paramObj) {
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

    public function updateCartQty($paramObj) {
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
                                  // ->whereDate('created_date','=',$current_date) //check records with today date
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

    public function getCartItems($paramObj) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try{
        //declare config repository
        $configRepo         = new ConfigRepository();

        $current_date_time  = date('Y-m-d H:i:s');
        $current_date       = date('Y-m-d');

        $retailer_id    = $paramObj->retailer_id;
        $retailshop_id  = $paramObj->retailshop_id;

        //get cart items
        $cart_items = DB::table('invoice_session')
                                ->where('retailer_id',$retailer_id)
                                ->where('retailshop_id',$retailshop_id)
                                ->get();

        if(isset($cart_items) && count($cart_items) > 0) {
          $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage'] = "Cart list downloaded successfully !";
          $returnedObj['cart_items'] = $cart_items;
          return $returnedObj;
        }
        //if cart is empty
        else{
          $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage'] = "The cart is empty !";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
        $returnedObj['aceplusStatusMessage'] = $e->getMessage(). " ----- line " .$e->getLine(). " ----- " .$e->getFile();
        return $returnedObj;
      }
    }
}
