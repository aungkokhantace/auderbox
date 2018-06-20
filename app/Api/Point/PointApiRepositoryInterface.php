<?php
namespace App\Api\Point;

/**
 * Author: Aung Ko Khant
 * Date: 2018-06-08
 * Time: 01:21 PM
 */
interface PointApiRepositoryInterface
{
  public function getRetailerTotalPoint($retailer_id,$retailshop_id);
}
