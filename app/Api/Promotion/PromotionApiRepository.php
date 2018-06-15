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

    public function getPromotionItemLevelByGroupId($group_id,$today_date,$alerted_promotion_id_array) {
      //get all item_level_promotions that are available today
      $result = PromotionItemLevel::where('promotion_item_level_group_id','=', $group_id)
                                        ->where('from_date','<=', $today_date)
                                        ->where('to_date','>=', $today_date)
                                        ->whereNotIn('id',$alerted_promotion_id_array)
                                        ->where('status','=',1)  //active
                                        ->whereNull('deleted_at') //not deleted
                                        ->get();
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
      $result = PromotionItemLevelGift::where('promotion_item_level_id','=', $level_id)
                                        ->where('status','=',1)  //active
                                        ->whereNull('deleted_at') //not deleted
                                        ->get();
      return $result;
    }

}
