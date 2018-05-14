<?php
namespace App\Api\ProductGroup;

use App\Core\ReturnMessage;
use App\Core\User\UserRepository;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\ProductCategory\ProductCategory;
use App\Backend\Product\Product;
use App\Backend\Retailshop\Retailshop;
use App\Backend\ProductDeliveryRestriction\ProductDeliveryRestriction;
use App\Backend\ProductGroup\ProductGroup;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 10:58 AM
 */

class ProductGroupApiRepository implements ProductGroupApiRepositoryInterface
{
    //brand_owner_id is '0' if there is no filter for product group, and if there is filter, brand_owner_id value will be set
    public function getProductGroupsByFilters($product_category_id,$brand_owner_id = 0, $restricted_product_group_id_array) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        $query          = ProductGroup::query();
        if(isset($brand_owner_id) && $brand_owner_id != null && $brand_owner_id !== 0){
            $query      = $query->where('product_group.brand_owner_id', $brand_owner_id);
        }
        $query          = $query->where('product_group.product_category_id', $product_category_id);
        $query          = $query->whereNotIn('product_group.id', $restricted_product_group_id_array);
        $query          = $query->whereNull('product_group.deleted_at');
        $query          = $query->where('product_group.status',1); //active product groups
        $product_groups = $query->get();

        if(isset($product_groups) && count($product_groups)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['resultObjs']            = $product_groups;
          return $returnedObj;
        }
        else{
          //if product groups do not exist
          $returnedObj['aceplusStatusMessage']  = "Product Groups do not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
