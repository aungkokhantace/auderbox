<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Session;
use App\Core\Check;
use App\Core\Redirect\AceplusRedirect;
use Illuminate\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\Api\Cart\CartApiRepository;
use App\Api\Cart\CartApiRepositoryInterface;
use App\Core\Utility;
use App\Api\Product\ProductApiRepository;
use App\Api\ShopList\ShopListApiRepository;
use App\Api\Promotion\PromotionApiRepositoryInterface;
use App\Core\PromotionConstance;

class PromotionApiController extends Controller
{
  public function __construct(PromotionApiRepositoryInterface $repo)
  {
      $this->repo = $repo;
  }

  public function downloadItemLevelPromotions_bk(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $cartApiRepo = new CartApiRepository();
        $shopListApiRepo = new ShopListApiRepository();
        $productApiRepo = new ProductApiRepository();

        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data'] = [];
        if (isset($params->download_item_level_promotions) && count($params->download_item_level_promotions) > 0) {
          //get ids
          $retailer_id = $params->download_item_level_promotions->retailer_id;
          $retailshop_id = $params->download_item_level_promotions->retailshop_id;

          $cart_items_result = $cartApiRepo->getCartItems($params->download_item_level_promotions);

          //if cart is empty, return at once!
          if(! isset($cart_items_result['cart_items'])){
            $returnedObj['aceplusStatusCode']     = $cart_items_result['aceplusStatusCode'];
            $returnedObj['aceplusStatusMessage']  = $cart_items_result['aceplusStatusMessage'];
            return \Response::json($returnedObj);
          }

          //else get cart_items
          $cart_items = $cart_items_result['cart_items'];

          //only product ids in cart
          $cart_items_product_id_array = array();

          foreach($cart_items as $cart_item) {
            $product_id = $cart_item->product_id;
            array_push($cart_items_product_id_array,$product_id);
          }

          //get today date to get available item level promotion groups
          $today_date = date('Y-m-d');

          //array to store promotion item levels
          $promotion_item_level_array = array();

          // array to store promotion detail information
          $promotion_item_level_detail_array = array();

          $promotion_item_level_groups = $this->repo->getAvailablePromotionItemLevelGroups($today_date);

          //if there is no available item level promo group for today, just return
          if(!(isset($promotion_item_level_groups) && count($promotion_item_level_groups) > 0)) {
            $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
            $returnedObj['aceplusStatusMessage']  = "No item level promotion group available today !";
            return \Response::json($returnedObj);
          }

          //get already alerted promotions
          $raw_already_alerted_promotions = $this->repo->getAlreadyAlertedPromotions($retailer_id,$retailshop_id);

          $alerted_promotion_id_array = array();
          foreach($raw_already_alerted_promotions as $raw_already_alerted_promotion){
            array_push($alerted_promotion_id_array,$raw_already_alerted_promotion->promotion_item_level_id);
          }

          foreach($promotion_item_level_groups as $promotion_item_level_group) {
            $group_id = $promotion_item_level_group->id;
            $promotion_item_levels = $this->repo->getPromotionItemLevelByGroupId($group_id, $today_date,$alerted_promotion_id_array);

            foreach($promotion_item_levels as $promotion_item_level){
              array_push($promotion_item_level_array, $promotion_item_level);
            }
          }

          // there are no item level promotion, just return
          if(count($promotion_item_level_array) == 0) {
            $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
            $returnedObj['aceplusStatusMessage']  = "No item level promotion available today !";
            return \Response::json($returnedObj);
          }

          foreach($promotion_item_level_array as $promotion_item_level_value){
            $promotion_item_level_id = $promotion_item_level_value->id;
            $promotion_item_level_details = $this->repo->getPromotionItemLevelDetailByLevelId($promotion_item_level_id, $today_date);

            $product_id_count = 0; //start counter

            //reset array
            $promotion_item_level_detail_array = array();
            $cart_item_array_included_in_promotion = array();

            foreach($promotion_item_level_details as $promotion_item_level_detail) {
              //add to detail array
              // $promotion_item_level_detail_array[$promotion_item_level_id][$product_id_count] = $promotion_item_level_detail->product_id;
              array_push($promotion_item_level_detail_array,$promotion_item_level_detail->product_id);
              $product_id_count++;
            }

            if(count($promotion_item_level_detail_array) == 0) {
              $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage']  = "No item level promotion detail available today !";
              return \Response::json($returnedObj);
            }

            //bind to promotion_item_level_obj
            $promotion_item_level_value->promotion_product_id_array = $promotion_item_level_detail_array;
            foreach($cart_items as $cart_item_obj){
              if(in_array($cart_item_obj->product_id , $promotion_item_level_detail_array)){
                array_push($cart_item_array_included_in_promotion, $cart_item_obj);
              }
            }

            $promotion_item_level_value->cart_item_array_included_in_promotion = $cart_item_array_included_in_promotion;
          }


          foreach($promotion_item_level_array as $promotion_item_level){
            $cart_items_that_match_promotion = $promotion_item_level->cart_item_array_included_in_promotion;
            if($promotion_item_level->promo_purchase_type == PromotionConstance::promotion_quantity_value){
              $cart_purchase_qty_for_promo = 0;
              foreach($cart_items_that_match_promotion as $cart_item_that_match_promotion) {
                $cart_purchase_qty_for_promo += $cart_item_that_match_promotion->quantity;
              }

              if($cart_purchase_qty_for_promo >= $promotion_item_level->purchase_qty){
                $item_level_promotion_id = $promotion_item_level->id;
                //get the promotion info
                // $promotionObj = $this->repo->getItemLevelPromotionById($item_level_promotion_id);
                $promotionObj = $promotion_item_level;
              }
            }
          }

          if(isset($promotionObj) && count($promotionObj) > 0) {
            //start checking promo_purchase_type
            if($promotionObj->promo_purchase_type == PromotionConstance::promotion_quantity_value) {
              $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_quantity_description;
            }
            else if($promotionObj->promo_purchase_type == PromotionConstance::promotion_amount_value) {
              $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_amount_description;
            }
            else if($promotionObj->promo_purchase_type == PromotionConstance::promotion_percentage_value) {
              $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_percentage_description;
            }
            //end checking promo_purchase_type

            //start checking promo_present_type
            if($promotionObj->promo_present_type == PromotionConstance::promotion_quantity_value) {
              $promotionObj->promo_present_type_text = PromotionConstance::promotion_quantity_description;
            }
            else if($promotionObj->promo_present_type == PromotionConstance::promotion_amount_value) {
              $promotionObj->promo_present_type_text = PromotionConstance::promotion_amount_description;
            }
            else if($promotionObj->promo_present_type == PromotionConstance::promotion_percentage_value) {
              $promotionObj->promo_present_type_text = PromotionConstance::promotion_percentage_description;
            }
            //end checking promo_present_type

            $current_purchase_qty = 0; // for currently purchased qty
            $current_purchase_amt = 0; // for currently purchased amt
            $purchased_products_array = array(); //to store details of purchased products
            $promo_products_array = array(); //to store details of promo products

            //start total_qurchase_qty, total_purchase_amt, and purchased_products_array
            foreach($promotionObj->cart_item_array_included_in_promotion as $cart_item){
              //calculate total purchase qty
              $current_purchase_qty += $cart_item->quantity;

              //start calculating total purchase amount
              $product_id          = $cart_item->product_id;
              $retailshop_id       = $cart_item->retailshop_id;

              //get retailshop object
              $retailshop = $shopListApiRepo->getShopById($retailshop_id);

              //get retailshop ward id
              $retailshop_address_ward_id = $retailshop->address_ward_id;

              //get product detail including price
              $product_detail_result = $productApiRepo->getProductDetailByID($product_id,$retailshop_address_ward_id);

              //if getting product details is not successful, return with error message
              if($product_detail_result["aceplusStatusCode"] !== ReturnMessage::OK){
                $returnedObj['aceplusStatusCode']     = $product_detail_result["aceplusStatusCode"];
                $returnedObj['aceplusStatusMessage']  = $product_detail_result["aceplusStatusMessage"];
                return \Response::json($returnedObj);
              }

              //get product_detail obj
              $product_detail = $product_detail_result["resultObj"];

              //define minimum_order_qty and maximum_order_qty (temporarily hard-coded for now)
              $product_detail->minimum_order_qty = 1;
              $product_detail->maximum_order_qty = 50;
              $product_detail->purchase_qty      = $cart_item->quantity;

              //push product detail to product array
              array_push($purchased_products_array,$product_detail);

              //add each product's [price*quantity] to current total purchase amount
              $current_purchase_amt += $product_detail->price * $product_detail->purchase_qty;
              //end calculating total purchase amount
            }

            $promotionObj->current_purchase_qty = $current_purchase_qty;
            $promotionObj->current_purchase_amt = $current_purchase_amt;
            //end total_qurchase_qty, total_purchase_amt, and purchased_products_array

            // start getting promo_product_array
            //only qty promotions for now
            if($promotionObj->promo_present_type = PromotionConstance::promotion_quantity_value){
              $promotion_gifts = $this->repo->getPromotionItemLevelGiftsByLevelId($promotion_item_level_id);

              if(count($promotion_gifts) == 0) {
                $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
                $returnedObj['aceplusStatusMessage']  = "No promotion gift available!";
                return \Response::json($returnedObj);
              }
            }
            // end getting promo_product_array

            //start additional qty or amt
            $additional_qty = 0;
            $additional_amt = 0.0;

            if($promotionObj->promo_purchase_type == PromotionConstance::promotion_quantity_value && $promotionObj->purchase_qty !== 0){
              //get exceeding qty (eg. if promo_purchase_qty is 5 and user currently buy a total of 7 exceeding qty is [7-5=2])
              $exceeding_purchase_qty = $promotionObj->current_purchase_qty % $promotionObj->purchase_qty;
              if($exceeding_purchase_qty !== 0){
                //get additional_qty (eg. if promo_purchase_qty is 5 and exceeding is [7-5=2] then, he needs additional [5-2=3] items to get next promotion)
                $additional_qty = $promotionObj->purchase_qty - $exceeding_purchase_qty;
              }
            }

            if($promotionObj->promo_purchase_type == PromotionConstance::promotion_amount_value && $promotionObj->purchase_amt !== 0.0){
              $exceeding_purchase_amt = $promotionObj->current_purchase_amt % $promotionObj->purchase_amt;
              if($exceeding_purchase_amt !== 0){
                $additional_amt = $promotionObj->purchase_amt - $exceeding_purchase_amt;
              }
            }

            foreach($promotion_gifts as $promo_gift) {
              if($promotionObj->promo_present_type == PromotionConstance::promotion_quantity_value && $promotionObj->purchase_qty !== 0){
                //get received promo qty (eg. if promo_purchase_qty is 5 and user currently buy a total of 16, the received promo qty is [int(16/5) = 3])
                $received_promo_qty = intval(floor($promotionObj->current_purchase_qty / $promotionObj->purchase_qty));
                $promo_gift->received_promo_qty = $received_promo_qty;
              }
            }

            $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
            $returnedObj['aceplusStatusMessage']  = "Downloaded Promotion Data Successfully !";
            $returnedObj['data'] = array();
            $returnedObj['data'][0]["received_promotion"]   = $promotionObj;
            $returnedObj['data'][0]["product_array"]        = $purchased_products_array;
            $returnedObj['data'][0]["promo_product_array"]  = $promotion_gifts;
            $returnedObj['data'][0]["additional_qty"]       = $additional_qty;
            $returnedObj['data'][0]["additional_amt"]       = $additional_amt;

            return \Response::json($returnedObj);

          }

        $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage']  = "No promotion available!";
        return \Response::json($returnedObj);
        }
        //API parameter is missing
        else{
          $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
          $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
          $returnedObj['data'] = [];
          return \Response::json($returnedObj);
        }
    }
    else{
        return \Response::json($checkServerStatusArray);
    }
  }

  public function downloadItemLevelPromotions(){
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          $cartApiRepo = new CartApiRepository();
          $shopListApiRepo = new ShopListApiRepository();
          $productApiRepo = new ProductApiRepository();

          $params             = $checkServerStatusArray['data'][0];

          $retailer_id = $params->download_item_level_promotions->retailer_id;
          $retailshop_id = $params->download_item_level_promotions->retailshop_id;

          $returnedObj['data'] = [];
          if (isset($params->download_item_level_promotions) && count($params->download_item_level_promotions) > 0) {
            //get ids
            $retailer_id = $params->download_item_level_promotions->retailer_id;
            $retailshop_id = $params->download_item_level_promotions->retailshop_id;

            $cart_items_result = $cartApiRepo->getCartItems($params->download_item_level_promotions);

            //if cart is empty, return at once!
            if(! isset($cart_items_result['cart_items'])){
              $returnedObj['aceplusStatusCode']     = $cart_items_result['aceplusStatusCode'];
              $returnedObj['aceplusStatusMessage']  = $cart_items_result['aceplusStatusMessage'];
              return \Response::json($returnedObj);
            }

            //else get cart_items
            $cart_items = $cart_items_result['cart_items'];

            //only product ids in cart
            $cart_items_product_id_array = array();

            foreach($cart_items as $cart_item) {
              $product_id = $cart_item->product_id;
              array_push($cart_items_product_id_array,$product_id);
            }

            //get today date to get available item level promotion groups
            $today_date = date('Y-m-d');

            //array to store promotion item levels
            $promotion_item_level_array = array();

            // array to store promotion detail information
            $promotion_item_level_detail_array = array();

            $promotion_item_level_groups = $this->repo->getAvailablePromotionItemLevelGroups($today_date);

            //if there is no available item level promo group for today, just return
            if(!(isset($promotion_item_level_groups) && count($promotion_item_level_groups) > 0)) {
              $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage']  = "No item level promotion group available today !";
              return \Response::json($returnedObj);
            }

            //get already alerted promotions
            $raw_already_alerted_promotions = $this->repo->getAlreadyAlertedPromotions($retailer_id,$retailshop_id);

            $alerted_promotion_id_array = array();
            foreach($raw_already_alerted_promotions as $raw_already_alerted_promotion){
              array_push($alerted_promotion_id_array,$raw_already_alerted_promotion->promotion_item_level_id);
            }

            foreach($promotion_item_level_groups as $promotion_item_level_group) {
              $group_id = $promotion_item_level_group->id;
              $promotion_item_levels = $this->repo->getPromotionItemLevelByGroupId($group_id, $today_date,$alerted_promotion_id_array);

              foreach($promotion_item_levels as $promotion_item_level){
                array_push($promotion_item_level_array, $promotion_item_level);
              }
            }

            // there are no item level promotion, just return
            if(count($promotion_item_level_array) == 0) {
              $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage']  = "No item level promotion available today !";
              return \Response::json($returnedObj);
            }

            foreach($promotion_item_level_array as $promotion_item_level_value){
              $promotion_item_level_id = $promotion_item_level_value->id;
              $promotion_item_level_details = $this->repo->getPromotionItemLevelDetailByLevelId($promotion_item_level_id, $today_date);

              $product_id_count = 0; //start counter

              //reset array
              $promotion_item_level_detail_array = array();
              $cart_item_array_included_in_promotion = array();

              foreach($promotion_item_level_details as $promotion_item_level_detail) {
                //add to detail array
                // $promotion_item_level_detail_array[$promotion_item_level_id][$product_id_count] = $promotion_item_level_detail->product_id;
                array_push($promotion_item_level_detail_array,$promotion_item_level_detail->product_id);
                $product_id_count++;
              }

              if(count($promotion_item_level_detail_array) == 0) {
                $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
                $returnedObj['aceplusStatusMessage']  = "No item level promotion detail available today !";
                return \Response::json($returnedObj);
              }

              //bind to promotion_item_level_obj
              $promotion_item_level_value->promotion_product_id_array = $promotion_item_level_detail_array;
              foreach($cart_items as $cart_item_obj){
                if(in_array($cart_item_obj->product_id , $promotion_item_level_detail_array)){
                  array_push($cart_item_array_included_in_promotion, $cart_item_obj);
                }
              }

              $promotion_item_level_value->cart_item_array_included_in_promotion = $cart_item_array_included_in_promotion;
            }

            foreach($promotion_item_level_array as $promotion_item_level){
              $cart_items_that_match_promotion = $promotion_item_level->cart_item_array_included_in_promotion;
              //if purchase type is qty
              if($promotion_item_level->promo_purchase_type == PromotionConstance::promotion_quantity_value){
                $cart_purchase_qty_for_promo = 0;
                foreach($cart_items_that_match_promotion as $cart_item_that_match_promotion) {
                  $cart_purchase_qty_for_promo += $cart_item_that_match_promotion->quantity;
                }

                //if cart_purchase_qty is more than promo_purchase_qty
                // if($cart_purchase_qty_for_promo >= $promotion_item_level->purchase_qty){
                  $item_level_promotion_id = $promotion_item_level->id;
                  //get the promotion info
                  // $promotionObj = $this->repo->getItemLevelPromotionById($item_level_promotion_id);
                  $promotionObj = $promotion_item_level;
                  break;
                // }
              }
            }
            // dd('promotion_product_id_array',$promotionObj->promotion_product_id_array);
            if(isset($promotionObj) && count($promotionObj) > 0) {
              //start checking promo_purchase_type
              if($promotionObj->promo_purchase_type == PromotionConstance::promotion_quantity_value) {
                $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_quantity_description;
              }
              else if($promotionObj->promo_purchase_type == PromotionConstance::promotion_amount_value) {
                $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_amount_description;
              }
              else if($promotionObj->promo_purchase_type == PromotionConstance::promotion_percentage_value) {
                $promotionObj->promo_purchase_type_text = PromotionConstance::promotion_percentage_description;
              }
              //end checking promo_purchase_type

              //start checking promo_present_type
              if($promotionObj->promo_present_type == PromotionConstance::promotion_quantity_value) {
                $promotionObj->promo_present_type_text = PromotionConstance::promotion_quantity_description;
              }
              else if($promotionObj->promo_present_type == PromotionConstance::promotion_amount_value) {
                $promotionObj->promo_present_type_text = PromotionConstance::promotion_amount_description;
              }
              else if($promotionObj->promo_present_type == PromotionConstance::promotion_percentage_value) {
                $promotionObj->promo_present_type_text = PromotionConstance::promotion_percentage_description;
              }
              //end checking promo_present_type

              $current_purchase_qty = 0; // for currently purchased qty
              $current_purchase_amt = 0; // for currently purchased amt
              $purchased_products_array = array(); //to store details of purchased products
              $promo_products_array = array(); //to store details of promo products

              //start total_qurchase_qty, total_purchase_amt, and purchased_products_array
              foreach($promotionObj->cart_item_array_included_in_promotion as $cart_item){
                //calculate total purchase qty
                $current_purchase_qty += $cart_item->quantity;

                //start calculating total purchase amount
                $product_id          = $cart_item->product_id;
                $retailshop_id       = $cart_item->retailshop_id;

                //get retailshop object
                $retailshop = $shopListApiRepo->getShopById($retailshop_id);

                //get retailshop ward id
                $retailshop_address_ward_id = $retailshop->address_ward_id;

                //get product detail including price
                $product_detail_result = $productApiRepo->getProductDetailByID($product_id,$retailshop_address_ward_id);

                //if getting product details is not successful, return with error message
                if($product_detail_result["aceplusStatusCode"] !== ReturnMessage::OK){
                  $returnedObj['aceplusStatusCode']     = $product_detail_result["aceplusStatusCode"];
                  $returnedObj['aceplusStatusMessage']  = $product_detail_result["aceplusStatusMessage"];
                  return \Response::json($returnedObj);
                }

                //get product_detail obj
                $product_detail = $product_detail_result["resultObj"];

                //define minimum_order_qty and maximum_order_qty (temporarily hard-coded for now)
                $product_detail->minimum_order_qty = 1;
                $product_detail->maximum_order_qty = 50;
                $product_detail->purchase_qty      = $cart_item->quantity;

                //push product detail to product array
                array_push($purchased_products_array,$product_detail);

                //add each product's [price*quantity] to current total purchase amount
                $current_purchase_amt += $product_detail->price * $product_detail->purchase_qty;
                //end calculating total purchase amount
              }

              $promotionObj->current_purchase_qty = $current_purchase_qty;
              $promotionObj->current_purchase_amt = $current_purchase_amt;
              //end total_qurchase_qty, total_purchase_amt, and purchased_products_array

              // start getting promo_product_array
              //only qty promotions for now
              if($promotionObj->promo_present_type = PromotionConstance::promotion_quantity_value){
                $promotion_gifts = $this->repo->getPromotionItemLevelGiftsByLevelId($promotion_item_level_id);

                if(count($promotion_gifts) == 0) {
                  $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
                  $returnedObj['aceplusStatusMessage']  = "No promotion gift available!";
                  return \Response::json($returnedObj);
                }
              }
              // end getting promo_product_array

              //start additional qty or amt
              $additional_qty = 0;
              $additional_amt = 0.0;

              if($promotionObj->promo_purchase_type == PromotionConstance::promotion_quantity_value && $promotionObj->purchase_qty !== 0){
                //get exceeding qty (eg. if promo_purchase_qty is 5 and user currently buy a total of 7 exceeding qty is [7-5=2])
                $exceeding_purchase_qty = $promotionObj->current_purchase_qty % $promotionObj->purchase_qty;
                if($exceeding_purchase_qty !== 0){
                  //get additional_qty (eg. if promo_purchase_qty is 5 and exceeding is [7-5=2] then, he needs additional [5-2=3] items to get next promotion)
                  $additional_qty = $promotionObj->purchase_qty - $exceeding_purchase_qty;
                }
              }

              if($promotionObj->promo_purchase_type == PromotionConstance::promotion_amount_value && $promotionObj->purchase_amt !== 0.0){
                $exceeding_purchase_amt = $promotionObj->current_purchase_amt % $promotionObj->purchase_amt;
                if($exceeding_purchase_amt !== 0){
                  $additional_amt = $promotionObj->purchase_amt - $exceeding_purchase_amt;
                }
              }

              //calculate received promo product qty for each promo product
              foreach($promotion_gifts as $promo_gift) {
                if($promotionObj->promo_present_type == PromotionConstance::promotion_quantity_value && $promotionObj->purchase_qty !== 0){
                  //get received promo qty (eg. if promo_purchase_qty is 5 and user currently buy a total of 16, the received promo qty is [int(16/5) = 3])
                  $received_promo_qty = intval(floor($promotionObj->current_purchase_qty / $promotionObj->purchase_qty));
                  $promo_gift->received_promo_qty = $received_promo_qty;
                }
              }

              // dd('$purchased_products_array',$purchased_products_array);


              //save the received promotion to invoice_session_show_noti table
              $promotion_item_level_id = $promotionObj->id;

              //returns true if mark as noti process is successful
              $shown_noti_result = $this->repo->markAsShownNoti($retailer_id,$retailshop_id,$promotion_item_level_id);

              if(!$shown_noti_result) {
                $returnedObj['aceplusStatusCode']     = ReturnMessage::INTERNAL_SERVER_ERROR;
                $returnedObj['aceplusStatusMessage']  = "Promotion cannot be marked as already shown!";
                return \Response::json($returnedObj);
              }
              

              //get all products included in current promotion
              $cart_item_id_array_included_in_promotion = array();
              foreach($cart_item_array_included_in_promotion as $cart_item_obj_in_promotion){
                array_push($cart_item_id_array_included_in_promotion,$cart_item_obj_in_promotion->product_id);
              }

              //here is all product ids in current promotion
              $all_product_ids_in_promotion = $promotionObj->promotion_product_id_array;

              $temp_product_ids_excluded_from_promotion = array_diff($all_product_ids_in_promotion,$cart_item_id_array_included_in_promotion);

              //reindex excluded array
              $product_ids_excluded_from_promotion = array_values($temp_product_ids_excluded_from_promotion);

              // dd('excluded',$product_ids_excluded_from_promotion);
              // dd('promotionObj',$promotionObj);

              //get product detail including price
              // $product_detail_result = $productApiRepo->getProductDetailByID($product_id,$retailshop_address_ward_id);

              foreach($product_ids_excluded_from_promotion as $excluded_product_id){
                // dd('$excluded_product_id',$excluded_product_id);
                $excluded_product_detail_result = $productApiRepo->getProductDetailByID($excluded_product_id,$retailshop_address_ward_id);
                // dd('excluded_details',$excluded_product_detail_result);
                //if getting product details is not successful, return with error message
                if($excluded_product_detail_result["aceplusStatusCode"] !== ReturnMessage::OK){
                  $returnedObj['aceplusStatusCode']     = $excluded_product_detail_result["aceplusStatusCode"];
                  $returnedObj['aceplusStatusMessage']  = $excluded_product_detail_result["aceplusStatusMessage"];
                  return \Response::json($returnedObj);
                }

              }


              //everything is ok
              $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage']  = "Downloaded Promotion Data Successfully !";
              $returnedObj['data'] = array();
              $returnedObj['data'][0]["received_promotion"]   = $promotionObj;
              $returnedObj['data'][0]["product_array"]        = $purchased_products_array;
              $returnedObj['data'][0]["promo_product_array"]  = $promotion_gifts;
              $returnedObj['data'][0]["additional_qty"]       = $additional_qty;
              $returnedObj['data'][0]["additional_amt"]       = $additional_amt;
              $returnedObj['data'][0]["current_purchase_qty"] = $current_purchase_qty;

              return \Response::json($returnedObj);

            }

          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "No promotion available!";
          return \Response::json($returnedObj);
          }
          //API parameter is missing
          else{
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
            $returnedObj['data'] = [];
            return \Response::json($returnedObj);
          }
      }
      else{
          return \Response::json($checkServerStatusArray);
      }
  }
}
