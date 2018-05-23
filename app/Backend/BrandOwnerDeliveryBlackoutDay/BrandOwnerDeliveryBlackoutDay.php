<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-17
 * Time: 03:45 PM
 */

namespace App\Backend\BrandOwnerDeliveryBlackoutDay;

use Illuminate\Database\Eloquent\Model;

class BrandOwnerDeliveryBlackoutDay extends Model
{
    protected $table = 'brand_owner_delivery_blackout_day';

    protected $casts = [
        'id' => 'integer',
        'brand_owner_id' => 'integer',
        'name' => 'string',
        'date' => 'string',
        'type' => 'integer',
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
        'name',
        'date',
        'type',
        'remark',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];


}
