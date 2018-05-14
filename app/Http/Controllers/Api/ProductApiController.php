<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 10:54 AM
 */

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use App\Core\Check;
use App\Core\Redirect\AceplusRedirect;
use Illuminate\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\Api\Product\ProductApiRepositoryInterface;
use App\Api\ShopList\ShopListApiRepository;
use App\Api\ProductDeliveryRestriction\ProductDeliveryRestrictionApiRepository;
use App\Api\ProductGroup\ProductGroupApiRepository;

class ProductApiController extends Controller
{
    public function __construct(ProductApiRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    //download product list
    public function getProductList(){
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          try {
              $shopListApiRepo = new ShopListApiRepository();
              $productDeliveryRestrictionRepo = new ProductDeliveryRestrictionApiRepository();
              $productGroupRepo = new ProductGroupApiRepository();

              $params             = $checkServerStatusArray['data'][0];

              if (isset($params->products) && count($params->products) > 0) {
                //get api parameters
                $product_category_id = $params->products->product_category_id;
                $retailshop_id       = $params->products->retailshop_id;
                $brand_owner_id      = $params->products->brand_owner_id;

                //get retailshop object
                $retailshop = $shopListApiRepo->getShopById($retailshop_id);

                //get retailshop ward id
                $retailshop_address_ward_id = $retailshop->address_ward_id;

                //array to store restricted product groups
                $restricted_product_group_id_array = array();

                // get products that are restricted in the retailshop's township
                //raw query result
                $raw_restricted_product_groups = $productDeliveryRestrictionRepo->getRestrictedProductsByWardId($retailshop_address_ward_id);
                // dd('raw',$raw_restricted_product_groups);
                //push to array
                foreach($raw_restricted_product_groups as $restricted_product_group){
                    array_push($restricted_product_group_id_array, $restricted_product_group->product_group_id);
                }

                //brand_owner_id is '0' if there is no filter for product group, and if there is filter, brand_owner_id value will be set
                $product_group_result = $productGroupRepo->getProductGroupsByFilters($product_category_id,$brand_owner_id,$restricted_product_group_id_array);

                if($product_group_result['aceplusStatusCode'] !== ReturnMessage::OK){
                  $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                  $returnedObj['aceplusStatusMessage'] = $product_group_result['aceplusStatusMessage'];
                  $returnedObj['data'] = [];
                  return \Response::json($returnedObj);
                }

                $raw_product_groups = $product_group_result['resultObjs'];

                $product_group_id_array = array();
                foreach($raw_product_groups as $product_group){
                  array_push($product_group_id_array,$product_group->id);
                }

                // $result = $this->repo->getAvailableProducts($product_category_id,$restricted_product_id_array,$retailshop_township_id);
                $product_result = $this->repo->getAvailableProducts($product_group_id_array,$retailshop_address_ward_id);

                if($product_result['aceplusStatusCode'] == ReturnMessage::OK){
                    $data = array();
                    $count = 0;

                    //add minimum_order_qty, maximum_order_qty, out_of_stock_flag
                    //all by default now
                    foreach($product_result['resultObjs'] as $result_product){
                      $result_product->minimum_order_qty = 1;
                      $result_product->maximum_order_qty = 50;
                      $result_product->out_of_stock_flag = 0;
                    }

                    $data[0]["products"] = $product_result['resultObjs'];

                    $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                    $returnedObj['aceplusStatusMessage'] = "Success!";
                    $returnedObj['data'] = $data;

                    return \Response::json($returnedObj);
                }
                else{
                  $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                  $returnedObj['aceplusStatusMessage'] = $product_result['aceplusStatusMessage'];
                  $returnedObj['data'] = [];
                  return \Response::json($returnedObj);
                }
              }
              //API parameter is missing
              else{
                $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
                $returnedObj['data'] = [];
                return \Response::json($returnedObj);
              }
          }
          catch (\Exception $e) {
              $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
              $returnedObj['aceplusStatusMessage'] = $e->getMessage() . " ----- line " . $e->getLine() . " ----- " . $e->getFile();
              $returnedObj['data'] = (object) array();
              return \Response::json($returnedObj);
          }
      }
      else{
          return \Response::json($checkServerStatusArray);
      }
    }

    //download product detail
    public function getProductDetail(){
        $temp                   = Input::All();
        $inputAll               = json_decode($temp['param_data']);
        $checkServerStatusArray = Check::checkCodes($inputAll);

        if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          try {
                $shopListApiRepo = new ShopListApiRepository();

                $params             = $checkServerStatusArray['data'][0];

                if (isset($params->product_detail) && count($params->product_detail) > 0) {
                  //get api parameters
                  $product_id          = $params->product_detail->product_id;
                  $retailshop_id       = $params->product_detail->retailshop_id;

                  //get retailshop object
                  $retailshop = $shopListApiRepo->getShopById($retailshop_id);

                  //get retailshop ward id
                  $retailshop_address_ward_id = $retailshop->address_ward_id;

                  //get product detail including price
                  $result = $this->repo->getProductDetailByID($product_id,$retailshop_address_ward_id);

                  if($result['aceplusStatusCode'] == ReturnMessage::OK){
                      $data = array();
                      //add minimum_order_qty, maximum_order_qty, out_of_stock_flag
                      //all by default now
                      $result['resultObj']->minimum_order_qty = 1;
                      $result['resultObj']->maximum_order_qty = 50;
                      $result['resultObj']->out_of_stock_flag = 0;

                      // create std object
                      $data[0] = new \stdClass();
                      $data[0]->product_detail = $result['resultObj'];

                      $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                      $returnedObj['aceplusStatusMessage'] = "Success!";
                      $returnedObj['data'] = $data;

                      return \Response::json($returnedObj);
                  }
                  else{
                    $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                    $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
                    $returnedObj['data'] = [];
                    return \Response::json($returnedObj);
                  }
                }
                //API parameter is missing
                else{
                  $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                  $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
                  $returnedObj['data'] = [];
                  return \Response::json($returnedObj);
                }
            }
            catch (\Exception $e) {
                $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                $returnedObj['aceplusStatusMessage'] = $e->getMessage() . " ----- line " . $e->getLine() . " ----- " . $e->getFile();
                $returnedObj['data'] = (object) array();
                return \Response::json($returnedObj);
            }
        }
        else{
            return \Response::json($checkServerStatusArray);
        }
    }
}
