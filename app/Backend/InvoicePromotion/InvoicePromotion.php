<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-22
 * Time: 10:48 AM
 */

namespace App\Backend\InvoicePromotion;

use Illuminate\Database\Eloquent\Model;

class InvoicePromotion extends Model
{
    protected $table = 'invoice_promotion';

    protected $casts = [
      'id' => 'string',
      'promotion_item_level_id' => 'integer',
      'invoice_id' => 'string',
      'product_id' => 'integer',
      'qty' => 'integer',
      'date' => 'string',
   ];

    protected $fillable = [
      'id',
      'promotion_item_level_id',
      'invoice_id',
      'product_id',
      'qty',
      'date',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];
}
