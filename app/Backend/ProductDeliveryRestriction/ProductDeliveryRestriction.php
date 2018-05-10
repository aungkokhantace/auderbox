<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 11:43 AM
 */

namespace App\Backend\ProductDeliveryRestriction;

use Illuminate\Database\Eloquent\Model;

class ProductDeliveryRestriction extends Model
{
    protected $table = 'product_delivery_restriction';

    protected $casts = [
       'id' => 'integer',
       'product_id' => 'integer',
       'state_id' => 'integer',
       'township_id' => 'integer',
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
        'product_id',
        'state_id',
        'township_id',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    public function product()
    {
        return $this->belongsTo('App\Backend\Product\Product','product_id','id');
    }

}
