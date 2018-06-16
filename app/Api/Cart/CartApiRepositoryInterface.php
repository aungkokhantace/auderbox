<?php
namespace App\Api\Cart;

/**
 * Author: Aung Ko Khant
 * Date: 2018-06-08
 * Time: 01:21 PM
 */
interface CartApiRepositoryInterface
{
  public function addToCart($paramObj);
  public function updateCartQty($paramObj);
  public function getCartItems($paramObj);
  public function clearCartItems($retailer_id,$retailshop_id);
}
