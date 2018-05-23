<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-08
 * Time: 10:54 AM
 */

namespace App\Backend\Retailer;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $table = 'retailers';

    protected $casts = [
       'id' => 'integer',
       'retailer_id' => 'integer',
       'user_id' => 'integer',
       'address_state_id' => 'string',
       'address_district_id' => 'string',
       'address_township_id' => 'string',
       'address_town_id' => 'string',
       'address_ward_id' => 'string',
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
        'user_id',
        'name_eng',
        'name_mm',
        'nrc',
        'dob',
        'phone',
        'email',
        'address',
        'photo',
        'nrc_front_photo',
        'nrc_back_photo',
        'address_state_id',
        'address_district_id',
        'address_township_id',
        'address_town_id',
        'address_ward_id',
        'remark',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
        ,
    ];


}
