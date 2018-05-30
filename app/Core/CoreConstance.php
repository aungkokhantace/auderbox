<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/21/2016
 * Time: 1:18 PM
 */

namespace App\Core;


class CoreConstance {

    const INVALID_CODE = "INVALID_CODE";
    const INVALID_PASSWORD = "INVALID_PASSWORD";

    //start invoice_detail types (to record order and cancel actions)
    const invoice_detatil_order_value = 1;
    const invoice_detatil_order_description = "Order";

    const invoice_detatil_cancel_value = 2;
    const invoice_detatil_cancel_description = "Cancel";
    //end invoice_detail types (to record order and cancel actions)



}
