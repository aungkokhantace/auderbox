<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 11:43 AM
 */

namespace App\Backend\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $casts = [
       'id' => 'integer',
       'product_group_id' => 'integer',
       'product_uom_type_id' => 'integer',
       'image' => 'string',
       'status' => 'integer',
       'price' => 'double',
       'created_by' => 'integer',
       'updated_by' => 'integer',
       'deleted_by' => 'integer',
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
       'deleted_at' => 'datetime'
   ];

    protected $fillable = [
        'id',
        'product_group_id',
        'product_uom_type_id',
        'image',
        'sku',
        'remark',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    public function product_category()
    {
        return $this->belongsTo('App\Backend\ProductCategory\ProductCategory','product_category_id','id');
    }

    public function product_delivery_restriction()
    {
        return $this->hasMany('App\Backend\ProductDeliveryRestriction\ProductDeliveryRestriction');
    }

    public function product_price()
    {
        return $this->hasMany('App\Backend\ProductPrice\ProductPrice');
    }

}
