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
       'state_id' => 'integer',
       'township_id' => 'integer',
       'retail_shop_type_id' => 'integer',
       'status' => 'boolean',
       'created_by' => 'integer',
       'updated_by' => 'integer',
       'deleted_by' => 'integer',
       'created_at' => 'timestamp',
       'updated_at' => 'timestamp',
       'deleted_at' => 'timestamp'
   ];

    protected $fillable = [
        'id',
        'retailer_id',
        'state_id',
        'township_id',
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
