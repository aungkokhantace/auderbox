<?php
namespace App\Api\ShopList;
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-04
 * Time: 11:41 AM
 */
interface ShopListApiRepositoryInterface
{
    public function getShopsByRetailerId($retailer_id);
    public function getShopById($id);
}
