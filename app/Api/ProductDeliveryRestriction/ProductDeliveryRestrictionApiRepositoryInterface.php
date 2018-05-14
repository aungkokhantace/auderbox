<?php
namespace App\Api\ProductDeliveryRestriction;
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 10:58 AM
 */
interface ProductDeliveryRestrictionApiRepositoryInterface
{
    public function getRestrictedProductsByWardId($ward_id);
}
