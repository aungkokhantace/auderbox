<?php
/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 10:45 AM
 */

namespace App\Backend\InvoiceDetail;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_detail';

    protected $casts = [
      'id' => 'string',
      'invoice_id' => 'string',
      'product_id' => 'integer',
      'product_group_id' => 'integer',
      'uom_id' => 'integer',
      'uom' => 'string',
      'quantity' => 'integer',
      'unit_price' => 'double',
      'net_amt' => 'double',
      'discount_amt' => 'double',
      'net_amt_w_disc' => 'double',
      'tax_amt' => 'double',
      'payable_amt' => 'double',
      'remark' => 'string',
      'confirm_by' => 'integer',
      'confirm_date' => 'string',
      'cancel_by' => 'integer',
      'cancel_date' => 'string',
      'status' => 'integer',
   ];

    protected $fillable = [
      'id',
      'invoice_id',
      'product_id',
      'product_group_id',
      'uom_id',
      'uom',
      'quantity',
      'unit_price',
      'net_amt',
      'discount_amt',
      'net_amt_w_disc',
      'tax_amt',
      'payable_amt',
      'remark',
      'confirm_by',
      'confirm_date',
      'cancel_by',
      'cancel_date',
      'status',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];
}
