<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-06-07
 * Time: 11:23 AM
 */

namespace App\Backend\InvoiceSession;

use Illuminate\Database\Eloquent\Model;

class InvoiceSession extends Model
{
    protected $table = 'invoice_session';

    protected $casts = [
      'id' => 'string',
      'retailer_id' => 'integer',
      'retailshop_id' => 'integer',
      'brand_owner_id' => 'integer',
      'product_id' => 'integer',
      'quantity' => 'integer',
      'created_date' => 'string',
   ];

    protected $fillable = [
      'id',
      'retailer_id',
      'retailshop_id',
      'brand_owner_id',
      'product_id',
      'quantity',
      'created_date',
    ];
}
