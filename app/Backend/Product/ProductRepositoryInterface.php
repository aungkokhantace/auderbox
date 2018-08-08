<?php
namespace App\Backend\Product;

/**
 * Author: Aung Ko Khant
 * Date: 2018-06-19
 * Time: 05:06 PM
 */
interface ProductRepositoryInterface
{
  public function getObjByID($id);
  public function getProductDetailByID($id, $ward_id);
}
