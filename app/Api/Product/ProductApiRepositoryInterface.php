<?php
namespace App\Api\Product;
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 10:58 AM
 */
interface ProductApiRepositoryInterface
{
    public function getAvailableProducts($product_group_id_array,$retailshop_address_ward_id);
    public function getProductDetailByID($id, $ward_id);
}
