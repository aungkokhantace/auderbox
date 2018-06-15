<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-06-13
 * Time: 02:15 PM
 */

namespace App\Backend\PromotionItemLevelDetail;

use Illuminate\Database\Eloquent\Model;

class PromotionItemLevelDetail extends Model
{
    protected $table = 'promotion_item_level_detail';

    protected $casts = [
      'id' => 'integer',
      'promotion_item_level_id' => 'integer',
      'product_id' => 'integer',
      'remark' => 'string',
      'from_date' => 'string',
      'to_date' => 'string',
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
      'promotion_item_level_id',
      'product_id',
      'remark',
      'from_date',
      'to_date',
      'status',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

}
