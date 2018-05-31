<?php
namespace App\Backend\Invoice;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-24
 * Time: 02:14 PM
 */
interface InvoiceRepositoryInterface
{
    public function getInvoiceList($from_date,$to_date,$status);
    public function getInvoiceDetail($invoice_id);
    public function deliver($paramObj);
}
