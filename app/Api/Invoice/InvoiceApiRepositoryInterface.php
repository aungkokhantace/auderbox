<?php
namespace App\Api\Invoice;

/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 11:11 AM
 */
interface InvoiceApiRepositoryInterface
{
    public function uploadInvoice($invoices);
    public function getInvoiceList($retailer_id,$filter);
}
