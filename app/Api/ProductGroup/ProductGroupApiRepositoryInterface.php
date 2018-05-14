<?php
namespace App\Api\ProductGroup;
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 10:58 AM
 */
interface ProductGroupApiRepositoryInterface
{
    public function getProductGroupsByFilters($product_category_id,$brand_owner_id,$restricted_product_group_id_array);
}
