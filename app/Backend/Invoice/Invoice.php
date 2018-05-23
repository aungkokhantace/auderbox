<?php
/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 10:45 AM
 */

namespace App\Backend\Invoice;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $casts = [
      'id' => 'string',
      'order_date' => 'date',
      'delivery_date' => 'date',
      'payment_date' => 'date',
      'retailer_id' => 'integer',
      'brand_owner_id' => 'integer',
      'retailshop_id' => 'integer',
      'tax_rate' => 'double',
      'total_net_amt' => 'double',
      'total_discount_amt' => 'double',
      'total_net_amt_w_disc' => 'double',
      'total_tax_amt' => 'double',
      'total_payable_amt' => 'double',
      'remark' => 'string',
      'confirm_by' => 'integer',
      'confirm_date' => 'date',
      'cancel_by' => 'integer',
      'cancel_date' => 'date',
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
      'order_date',
      'delivery_date',
      'payment_date',
      'retailer_id',
      'brand_owner_id',
      'retailshop_id',
      'tax_rate',
      'total_net_amt',
      'total_discount_amt',
      'total_net_amt_w_disc',
      'total_tax_amt',
      'total_payable_amt',
      'remark',
      'confirm_by',
      'confirm_date',
      'cancel_by',
      'cancel_date',
      'status',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

}
