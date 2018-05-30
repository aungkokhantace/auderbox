<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-30
 * Time: 03:10 PM
 */

namespace App\Backend\InvoiceDetailHistory;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetailHistory extends Model
{
    protected $table = 'invoice_detail_history';

    protected $casts = [
      'id' => 'string',
      'invoice_detail_id' => 'string',
      'qty' => 'integer',
      'date' => 'string',
      'type' => 'integer',
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
      'invoice_detail_id',
      'qty',
      'date',
      'type',
      'status',
      'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];
}
