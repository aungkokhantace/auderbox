<?php
namespace App\Api\Promotion;

/**
 * Author: Aung Ko Khant
 * Date: 2018-06-13
 * Time: 01:24 PM
 */
interface PromotionApiRepositoryInterface
{
    public function getAvailablePromotionItemLevelGroups($today_date);
    public function getPromotionItemLevelByGroupId($group_id,$today_date,$alerted_promotion_id_array);
    public function getPromotionItemLevelDetailByLevelId($level_id,$today_date);
    public function getAlreadyAlertedPromotions($retailer_id,$retailshop_id);
    public function checkAlreadyShownNoti($retailer_id,$retailshop_id,$item_level_promotion_id);
    public function getItemLevelPromotionById($id);
    public function getPromotionItemLevelGiftsByLevelId($level_id);
}
