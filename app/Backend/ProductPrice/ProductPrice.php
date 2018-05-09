<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 01:19 PM
 */

namespace App\Backend\ProductPrice;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $table = 'product_price';

    protected $fillable = [
        'id',
        'price',
        'state_id',
        'township_id',
        'product_id',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    public function product()
    {
        return $this->belongsTo('App\Backend\Product\Product','product_id','id');
    }

}
