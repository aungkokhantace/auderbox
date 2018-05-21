<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-17
 * Time: 03:45 PM
 */

namespace App\Backend\DeliveryRoute;

use Illuminate\Database\Eloquent\Model;

class DeliveryRoute extends Model
{
    protected $table = 'delivery_route';

    protected $casts = [
        'id' => 'integer',
        'route_name' => 'string',
        'route_code' => 'string',
        'brand_owner_id' => 'integer',
        'car_id' => 'integer',
        'remark' => 'string',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp'
   ];

    protected $fillable = [
        'id',
        'route_name',
        'route_code',
        'brand_owner_id',
        'car_id',
        'remark',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];


}
