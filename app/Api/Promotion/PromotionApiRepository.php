<?php
namespace App\Api\Promotion;

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
use App\Backend\PromotionItemLevelGroup\PromotionItemLevelGroup;
use App\Backend\PromotionItemLevel\PromotionItemLevel;
use App\Backend\PromotionItemLevelDetail\PromotionItemLevelDetail;
use App\Backend\PromotionItemLevelGift\PromotionItemLevelGift;

/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 11:11 AM
 */

class PromotionApiRepository implements PromotionApiRepositoryInterface
{
    public function getAvailablePromotionItemLevelGroups($today_date) {
      //get all item_level_promotion groups that are available today
      $result = PromotionItemLevelGroup::where('from_date','<=', $today_date)
                                        ->where('to_date','>=', $today_date)
                                        ->where('status','=',1)  //active
                                        ->whereNull('deleted_at') //not deleted
                                        ->get();
      return $result;
    }

    public function getPromotionItemLevelByGroupId($group_id,$today_date,$alerted_promotion_id_array=[]) {
      //get all item_level_promotions that are available today
      // $result = PromotionItemLevel::select('promotion_item_levels.*','product_lines.name as product_line_name')
      //                                   ->leftJoin('product_lines', 'promotion_item_levels.product_line_id', '=', 'product_lines.id')
      //                                   ->where('promotion_item_levels.promotion_item_level_group_id','=', $group_id)
      //                                   ->where('promotion_item_levels.from_date','<=', $today_date)
      //                                   ->where('promotion_item_levels.to_date','>=', $today_date)
      //                                   ->whereNotIn('promotion_item_levels.id',$alerted_promotion_id_array)
      //
      //                                   ->where('promotion_item_levels.status','=',1)  //active
      //                                   ->where('product_lines.status','=',1)  //active
      //
      //                                   ->whereNull('promotion_item_levels.deleted_at') //not deleted
      //                                   ->whereNull('product_lines.deleted_at') //not deleted
      //                                   ->get();

      $query = PromotionItemLevel::query();
      $query = $query->select('promotion_item_levels.*','product_lines.name as product_line_name');
      $query = $query->leftJoin('product_lines', 'promotion_item_levels.product_line_id', '=', 'product_lines.id');
      $query = $query->where('promotion_item_levels.promotion_item_level_group_id','=', $group_id);
      $query = $query->where('promotion_item_levels.from_date','<=', $today_date);
      $query = $query->where('promotion_item_levels.to_date','>=', $today_date);

      if(isset($alerted_promotion_id_array) && count($alerted_promotion_id_array) > 0){
        $query = $query->whereNotIn('promotion_item_levels.id',$alerted_promotion_id_array);
      }

      $query = $query->where('promotion_item_levels.status','=',1);  //active;
      $query = $query->where('product_lines.status','=',1);  //active;

      $query = $query->whereNull('promotion_item_levels.deleted_at'); //not deleted;
      $query = $query->whereNull('product_lines.deleted_at'); //not deleted;
      $result = $query->get();

      return $result;
    }

    public function getPromotionItemLevelDetailByLevelId($level_id,$today_date) {
      //get all item_level_promotion_details that are available today
      $result = PromotionItemLevelDetail::where('promotion_item_level_id','=', $level_id)
                                        ->where('from_date','<=', $today_date)
                                        ->where('to_date','>=', $today_date)
                                        ->where('status','=',1)  //active
                                        ->whereNull('deleted_at') //not deleted
                                        ->get();
      return $result;
    }

    public function getAlreadyAlertedPromotions($retailer_id,$retailshop_id) {
      $result = DB::table('invoice_session_show_noti')
                          ->where('retailer_id','=',$retailer_id)
                          ->where('retailshop_id','=',$retailshop_id)
                          ->where('one_time_alerted','=', 1) //don't show one-time alerted promotions
                          ->orWhere('do_not_show_again_ticked','=', 1) //don't show 'do_not_show_again' checked promotions
                          ->get();
      return $result;
    }

    public function checkAlreadyShownNoti($retailer_id,$retailshop_id,$item_level_promotion_id) {
      $already_shown_noti_flag = false;
      $result = DB::table('invoice_session_show_noti')
                          ->where('retailer_id','=',$retailer_id)
                          ->where('retailshop_id','=',$retailshop_id)
                          ->where('promotion_item_level_id','=',$item_level_promotion_id)
                          ->get();

      if(isset($result) && count($result) > 0) {
        $already_shown_noti_flag = true;
      }
      return $already_shown_noti_flag;
    }

    public function getItemLevelPromotionById($id) {
      $result = PromotionItemLevel::find($id);
      return $result;
    }

    public function getPromotionItemLevelGiftsByLevelId($level_id) {
      //get all item_level_promotion_gifts
      $result = PromotionItemLevelGift::select('promotion_item_level_gifts.*','product_group.name as promo_product_name')
                                        ->leftJoin('products', 'products.id', '=', 'promotion_item_level_gifts.promo_product_id')
                                        ->leftJoin('product_group', 'product_group.id', '=', 'products.product_group_id')

                                        ->where('promotion_item_level_gifts.promotion_item_level_id','=', $level_id)

                                        ->where('promotion_item_level_gifts.status','=',1)  //active
                                        ->where('product_group.status','=',1)  //active
                                        ->where('products.status','=',1)  //active

                                        ->whereNull('promotion_item_level_gifts.deleted_at') //not deleted
                                        ->whereNull('product_group.deleted_at') //not deleted
                                        ->whereNull('products.deleted_at') //not deleted
                                        ->get();
      return $result;
    }

    public function checkPromotionForproduct($product_id, $product_line_id,$today_date) {
      $result = PromotionItemLevel::select('promotion_item_levels.*')
                                    ->leftJoin('promotion_item_level_detail', 'promotion_item_level_detail.promotion_item_level_id', '=', 'promotion_item_levels.id')

                                    ->where('promotion_item_levels.from_date','<=', $today_date)
                                    ->where('promotion_item_levels.to_date','>=', $today_date)

                                    ->where('promotion_item_level_detail.from_date','<=', $today_date)
                                    ->where('promotion_item_level_detail.to_date','>=', $today_date)

                                    ->where('promotion_item_level_detail.product_id','=',$product_id)
                                    ->where('promotion_item_levels.product_line_id','=',$product_line_id)

                                    ->where('promotion_item_levels.status','=',1)  //active record
                                    ->where('promotion_item_level_detail.status','=',1)  //active record

                                    ->whereNull('promotion_item_levels.deleted_at')  //not deleted
                                    ->whereNull('promotion_item_level_detail.deleted_at')  //not deleted

                                    ->first();

      return $result;
    }

    // public function markAsShownNoti($retailer_id,$retailshop_id,$promotion_item_level_id){
    public function  markAsShownNoti($retailer_id,$retailshop_id,$promotion_item_level_id,$one_time_alerted,$do_not_show_again_ticked) {
      //clear old records with these ids to avoid data duplication
      // DB::table('invoice_session_show_noti')
      //         ->where('retailer_id','=',$retailer_id)
      //         ->where('retailshop_id','=',$retailshop_id)
      //         ->where('promotion_item_level_id','=',$promotion_item_level_id)
      //         ->delete();
      $result = true;

      $old_record = DB::table('invoice_session_show_noti')
              ->where('retailer_id','=',$retailer_id)
              ->where('retailshop_id','=',$retailshop_id)
              ->where('promotion_item_level_id','=',$promotion_item_level_id)
              ->first();

      // if there is already data in show_noti table, update the record
      if(isset($old_record) && count($old_record) > 0) {
        if(($old_record->one_time_alerted !== $one_time_alerted) || ($old_record->do_not_show_again_ticked !== $do_not_show_again_ticked)) {
          $result = DB::table('invoice_session_show_noti')
          ->where('retailer_id', $retailer_id)
          ->where('retailshop_id', $retailshop_id)
          ->where('promotion_item_level_id','=',$promotion_item_level_id)
          ->update([
            'one_time_alerted' => $one_time_alerted,
            'do_not_show_again_ticked' => $do_not_show_again_ticked
          ]);
        }
      }
      //if there is no record already, insert a new record
      else {

        $result = DB::table('invoice_session_show_noti')->insert([
          'retailer_id'               => $retailer_id,
          'retailshop_id'             => $retailshop_id,
          'promotion_item_level_id'   => $promotion_item_level_id,
          'one_time_alerted'          => $one_time_alerted,
          'do_not_show_again_ticked'  => $do_not_show_again_ticked
        ]);
      }

      return $result;
    }
}
