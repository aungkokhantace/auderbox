<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-06-14
 * Time: 11:24 AM
 */

namespace App\Backend\PromotionItemLevelGift;

use Illuminate\Database\Eloquent\Model;

class PromotionItemLevelGift extends Model
{
    protected $table = 'promotion_item_level_gifts';

    protected $casts = [
      'id'                      => 'integer',
      'promotion_item_level_id' => 'integer',
      'promo_product_id'        => 'integer',
      'promo_qty'               => 'integer',
      'status'                  => 'integer',
      'created_by'              => 'integer',
      'updated_by'              => 'integer',
      'deleted_by'              => 'integer',
      'created_at'              => 'datetime',
      'updated_at'              => 'datetime',
      'deleted_at'              => 'datetime'
   ];

    protected $fillable = [
      'id',
      'promotion_item_level_id',
      'promo_product_id',
      'promo_qty',
      'status',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

}
