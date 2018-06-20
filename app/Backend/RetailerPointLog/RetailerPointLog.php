<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-06-19
 * Time: 05:06 PM
 */

namespace App\Backend\RetailerPointLog;

use Illuminate\Database\Eloquent\Model;

class RetailerPointLog extends Model
{
    protected $table = 'retailer_point_log';

    protected $casts = [
      'id' => 'string',
      'retailer_point_id' => 'integer',
      'created_date' => 'string',
      'points' => 'integer',
      'retailer_reward_id' => 'integer',
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
      'retailer_point_id',
      'created_date',
      'points',
      'retailer_reward_id',
      'status',
      'created_by',
      'updated_by',
      'deleted_by',
      'created_at',
      'updated_at',
      'deleted_at'
    ];

}
