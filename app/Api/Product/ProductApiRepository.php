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
    public function getAvailableProducts($product_group_id_array,$retailshop_address_ward_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $products = Product::select('products.*','product_price.price','product_group.name as name','product_uom_type.name_eng as product_uom_type_name_eng','product_uom_type.name_mm as product_uom_type_name_mm','product_volume_type.name as product_volume_type_name','product_uom_type.total_quantity as total_uom_quantity')

                              ->leftJoin('product_price', 'products.id', '=', 'product_price.product_id')
                              ->leftJoin('product_group', 'products.product_group_id', '=', 'product_group.id')
                              ->leftJoin('product_uom_type', 'products.product_uom_type_id', '=', 'product_uom_type.id')
                              ->leftJoin('product_volume_type', 'product_group.product_volume_type_id', '=', 'product_volume_type.id')

                              ->whereIn('products.product_group_id',$product_group_id_array)
                              ->where('product_price.address_ward_id',$retailshop_address_ward_id) //price varies according to retail shop location
                              ->whereNull('products.deleted_at')
                              ->whereNull('product_price.deleted_at')
                              ->where('products.status',1) //get active products
                              ->where('product_price.status',1) //get active product price
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
