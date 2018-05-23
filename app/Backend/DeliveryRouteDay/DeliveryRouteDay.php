<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-17
 * Time: 03:45 PM
 */

namespace App\Backend\DeliveryRouteDay;

use Illuminate\Database\Eloquent\Model;

class DeliveryRouteDay extends Model
{
    protected $table = 'delivery_route_day';

    protected $casts = [
        'id' => 'integer',
        'delivery_route_id' => 'integer',
        'monday' => 'integer',
        'tuesday' => 'integer',
        'wednesday' => 'integer',
        'thursday' => 'integer',
        'friday' => 'integer',
        'saturday' => 'integer',
        'sunday' => 'integer',
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
        'delivery_route_id',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];


}
