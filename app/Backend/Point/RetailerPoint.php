<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-06-19
 * Time: 05:06 PM
 */

namespace App\Backend\Point;

use Illuminate\Database\Eloquent\Model;

class RetailerPoint extends Model
{
    protected $table = 'retailer_point';

    protected $casts = [
      'id' => 'string',
      'retailer_id' => 'integer',
      'retailshop_id' => 'integer',
      'brand_owner_id' => 'integer',
      'invoice_id' => 'string',
      'used_points' => 'integer',
      'available_points' => 'integer',
      'total_points' => 'integer',
      'with_expiration' => 'integer',
      'expiry_date' => 'string',
      'remark' => 'string',
      'status' => 'integer',
      'created_by' => 'integer',
      'updated_by' => 'integer',
      'deleted_by' => 'integer',
      'created_at' => 'string',
      'updated_at' => 'string',
      'deleted_at' => 'string'
   ];

    protected $fillable = [
      'id',
      'retailer_id',
      'retailshop_id',
      'brand_owner_id',
      'invoice_id',
      'used_points',
      'available_points',
      'total_points',
      'with_expiration',
      'expiry_date',
      'remark',
      'status',
      'created_by',
      'updated_by',
      'deleted_by',
      'created_at',
      'updated_at',
      'deleted_at'
    ];

}
