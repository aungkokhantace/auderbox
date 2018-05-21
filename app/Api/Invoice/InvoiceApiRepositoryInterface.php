<?php
namespace App\Api\Invoice;

/**
 * Author: Khin Zar Ni Wint
 * Date: 2018-05-21
 * Time: 11:11 AM
 */
interface InvoiceApiRepositoryInterface
{
    public function saveInvoice($paramObj,$invoice_id);
    public function saveInvoiceDetail($detailObj,$detail_id,$invoice_id);
    public function uploadInvoice($invoices);
}
