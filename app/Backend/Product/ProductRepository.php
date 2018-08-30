<?php
namespace App\Backend\Product;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Core\StatusConstance;
use App\Core\Config\ConfigRepository;
use Carbon\Carbon;
use App\Backend\Retailshop\Retailshop;
use Auth;
use App\Log\LogCustom;
use App\Core\CoreConstance;
use App\Backend\Product\Product;


/**
 * Author: Aung Ko Khant
 * Date: 2018-06-19
 * Time: 05:06 PM
 */

class ProductRepository implements ProductRepositoryInterface
{
  public function getObjByID($id){
    $result = Product::find($id);
    return $result;
  }

  public function getProductDetailByID($id, $ward_id){
    $returnedObj = array();
    $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

    try{
      $product = Product::select('products.*','product_price.price','product_group.name as name','product_uom_type.name_eng as product_uom_type_name_eng','product_uom_type.name_mm as product_uom_type_name_mm','product_volume_type.name as product_volume_type_name','product_container_type.name as product_container_type_name','product_uom_type.total_quantity as total_uom_quantity','product_lines.id as product_line_id','product_lines.name as product_line_name','brand_owners.name as brand_owner_name')

                            ->leftJoin('product_price', 'products.id', '=', 'product_price.product_id')
                            ->leftJoin('product_group', 'products.product_group_id', '=', 'product_group.id')
                            ->leftJoin('product_uom_type', 'products.product_uom_type_id', '=', 'product_uom_type.id')
                            ->leftJoin('product_volume_type', 'product_group.product_volume_type_id', '=', 'product_volume_type.id')
                            ->leftJoin('product_container_type', 'product_group.product_container_type_id', '=', 'product_container_type.id')
                            ->leftJoin('product_lines', 'product_lines.id', '=', 'product_group.product_line_id')
                            ->leftJoin('brand_owners', 'brand_owners.id', '=', 'product_group.brand_owner_id')

                            ->where('products.id',$id)
                            ->where('product_price.address_ward_id',$ward_id) //price vary according to retail shop location

                            //get records that are not deleted
                            ->whereNull('products.deleted_at')
                            ->whereNull('product_price.deleted_at')
                            ->whereNull('product_group.deleted_at')
                            ->whereNull('product_uom_type.deleted_at')
                            ->whereNull('product_volume_type.deleted_at')
                            ->whereNull('product_lines.deleted_at')
                            ->whereNull('brand_owners.deleted_at')

                            //get active records
                            ->where('products.status',1)
                            ->where('product_price.status',1)
                            ->where('product_group.status',1)
                            ->where('product_uom_type.status',1)
                            ->where('product_volume_type.status',1)
                            ->where('product_lines.status',1)
                            ->where('brand_owners.status',1)

                            ->first();
      if(isset($product) && count($product) > 0){
        $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage'] = "Success!";
        $returnedObj['resultObj'] = $product;
      }
      else{
        $returnedObj['aceplusStatusMessage'] = "Product does not exist!";
      }
      return $returnedObj;
    }
    catch(\Exception $e){
        $returnedObj['aceplusStatusMessage'] = $e->getMessage();
        return $returnedObj;
    }
  }
  
}