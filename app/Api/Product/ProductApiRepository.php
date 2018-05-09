<?php
namespace App\Api\Product;

use App\Core\ReturnMessage;
use App\Core\User\UserRepository;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\ProductCategory\ProductCategory;
use App\Backend\Product\Product;
use App\Backend\Retailshop\Retailshop;
use App\Backend\ProductDeliveryRestriction\ProductDeliveryRestriction;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 10:58 AM
 */

class ProductApiRepository implements ProductApiRepositoryInterface
{
    public function getAvailableProducts($product_category_id, $restricted_product_id_array, $retailshop_township_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        //get products
        $products = Product::select('products.*','product_price.price')
                              ->leftJoin('product_price', 'products.id', '=', 'product_price.product_id')
                              ->where('products.product_category_id',$product_category_id)
                              ->where('product_price.township_id',$retailshop_township_id) //price vary according to retail shop location
                              ->whereNotIn('products.id', $restricted_product_id_array)
                              ->whereNull('products.deleted_at')
                              ->whereNull('product_price.deleted_at')
                              ->where('products.status',1) //get active products
                              ->get();

        if(isset($products) && count($products)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['resultObjs']            = $products;
          return $returnedObj;
        }
        else{
          //if products do not exist
          $returnedObj['aceplusStatusMessage']  = "Products do not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }

    public function getProductDetailByID($id, $township_id){
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try{
        $product = Product::select('products.*','product_price.price')
                              ->leftJoin('product_price', 'products.id', '=', 'product_price.product_id')
                              ->where('products.id',$id)
                              ->where('product_price.township_id',$township_id) //price vary according to retail shop location
                              ->whereNull('products.deleted_at')
                              ->whereNull('product_price.deleted_at')
                              ->first();

        $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage'] = "Success!";
        $returnedObj['resultObj'] = $product;
        return $returnedObj;
      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
