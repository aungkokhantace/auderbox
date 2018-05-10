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
       'product_category_id' => 'integer',
       'brand_owner_id' => 'integer',
       'status' => 'boolean',
       'price' => 'float',
       'created_by' => 'integer',
       'updated_by' => 'integer',
       'deleted_by' => 'integer',
       'created_at' => 'timestamp',
       'updated_at' => 'timestamp',
       'deleted_at' => 'timestamp'
   ];

    protected $fillable = [
        'id',
        'product_category_id',
        'brand_owner_id',
        'name',
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
