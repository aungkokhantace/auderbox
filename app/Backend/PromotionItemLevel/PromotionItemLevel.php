<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-06-13
 * Time: 02:15 PM
 */

namespace App\Backend\PromotionItemLevel;

use Illuminate\Database\Eloquent\Model;

class PromotionItemLevel extends Model
{
    protected $table = 'promotion_item_levels';

    protected $casts = [
      'id' => 'integer',
      'promotion_item_level_group_id' => 'integer',
      'code' => 'string',
      'name' => 'string',
      'promo_purchase_type' => 'integer',
      'promo_present_type' => 'integer',
      'from_date' => 'string',
      'to_date' => 'string',
      'purchase_amt' => 'double',
      'purchase_qty' => 'integer',
      'promo_percentage' => 'double',
      'promo_amt' => 'double',
      'max_count_apply' => 'integer',
      'promo_allow_max_count' => 'integer',
      'remark' => 'string',
      'status' => 'integer',
      'created_by' => 'integer',
      'updated_by' => 'integer',
      'deleted_by' => 'integer',
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
      'deleted_at' => 'datetime'
   ];

    protected $fillable = [
      'id',
      'promotion_item_level_group_id',
      'code',
      'name',
      'promo_purchase_type',
      'promo_present_type',
      'from_date',
      'to_date',
      'purchase_amt',
      'purchase_qty',
      'promo_percentage',
      'promo_amt',
      'max_count_apply',
      'promo_allow_max_count',
      'remark',
      'status',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

}
