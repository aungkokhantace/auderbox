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
       'state_id' => 'integer',
       'township_id' => 'integer',
       'status' => 'tinyinteger',
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
        'state_id',
        'township_id',
        'remark',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
        ,
    ];


}
