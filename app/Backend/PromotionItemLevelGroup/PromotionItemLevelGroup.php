<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-06-13
 * Time: 02:15 PM
 */

namespace App\Backend\PromotionItemLevelGroup;

use Illuminate\Database\Eloquent\Model;

class PromotionItemLevelGroup extends Model
{
    protected $table = 'promotion_item_level_groups';

    protected $casts = [
      'id' => 'integer',
      'brand_owner_id' => 'integer',
      'code' => 'string',
      'name' => 'string',
      'from_date' => 'string',
      'to_date' => 'string',
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
      'brand_owner_id',
      'code',
      'name',
      'from_date',
      'to_date',
      'remark',
      'status',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

}
