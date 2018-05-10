<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 11:43 AM
 */

namespace App\Backend\ProductCategory;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category';

    protected $casts = [
       'id' => 'integer',
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
        'name',
        'remark',
        'status',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    public function product()
    {
        return $this->hasMany('App\Backend\Product\Product');
    }

}
