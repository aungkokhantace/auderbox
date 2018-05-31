<?php namespace App\Core;
/**
 * Created by PhpStorm.
 * Author: Khin Zar Ni wint
 * Date: 07/02/2018
 * Time: 4:56 PM
 */

class StatusConstance {
  /*
    //start invoice statuses for full version
    const status_pending_value = 1;
    const status_pending_description = "Pending";

    const status_confirm_value = 2;
    const status_confirm_description = "Confirmed";

    const status_deliver_value = 3;
    const status_deliver_description = "Delivered";

    const status_retailer_cancel_value = 4;
    const status_retailer_cancel_description = "Retailer Cancelled";

    const status_brand_owner_cancel_value = 5;
    const status_brand_owner_cancel_description = "Brand Owner Cancelled";

    const status_auderbox_cancel_value = 6;
    const status_auderbox_cancel_description = "Auderbox Cancelled";
    //end invoice statuses for full version
  */

  //start invoice statuses for pilot version
  const status_confirm_value = 2;
  const status_confirm_description = "Ordered";

  const status_deliver_value = 3;
  const status_deliver_description = "Delivered";

  const status_retailer_cancel_value = 4;
  const status_retailer_cancel_description = "Canceled";
  //end invoice statuses for pilot version

}
