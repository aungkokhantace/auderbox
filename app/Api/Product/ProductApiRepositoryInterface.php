<?php
namespace App\Api\Product;
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 10:58 AM
 */
interface ProductApiRepositoryInterface
{
    public function getAvailableProducts($product_category_id,$restricted_product_id_array,$retailshop_township_id);
    public function getProductDetailByID($id, $township_id);
}
