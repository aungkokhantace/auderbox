<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-08
 * Time: 04:27 PM
 */

namespace App\Backend\Retailshop;

use Illuminate\Database\Eloquent\Model;

class Retailshop extends Model
{
    protected $table = 'retailshops';

    protected $casts = [
       'id' => 'integer',
       'retailer_id' => 'integer',
       'address_state_id' => 'string',
       'address_district_id' => 'string',
       'address_township_id' => 'string',
       'address_town_id' => 'string',
       'address_ward_id' => 'string',
       'retail_shop_type_id' => 'integer',
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
        'retailer_id',
        'address_state_id',
        'address_district_id',
        'address_township_id',
        'address_town_id',
        'address_ward_id',
        'name_eng',
        'name_mm',
        'registration_no',
        'phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'retail_shop_type_id',
        'remark',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    // public function township()
    // {
    //     return $this->belongsTo('App\Backend\Township\Township','township_id','id');
    // }

}
