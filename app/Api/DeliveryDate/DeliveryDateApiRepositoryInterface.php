<?php
namespace App\Api\DeliveryDate;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-15
 * Time: 11:44 AM
 */
interface DeliveryDateApiRepositoryInterface
{
    public function calculateDeliveryDate($brand_owner_id, $retailshop_id);
}
