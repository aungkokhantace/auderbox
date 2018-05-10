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

              $params             = $checkServerStatusArray['data'][0];

              if (isset($params->products) && count($params->products) > 0) {
                //get api parameters
                $product_category_id = $params->products->product_category_id;
                $retailshop_id       = $params->products->retailshop_id;

                //get retailshop object
                $retailshop = $shopListApiRepo->getShopById($retailshop_id);

                //get state and township id
                // $retailshop_state_id = $retailshop->state_id;
                $retailshop_township_id = $retailshop->township_id;

                //array to store restricted products
                $restricted_product_id_array = array();

                // get products that are restricted in the retailshop's township
                //raw query result
                $raw_restricted_products = $productDeliveryRestrictionRepo->getRestrictedProductsByTownshipId($retailshop_township_id);

                //push to array
                foreach($raw_restricted_products as $restricted_product){
                    array_push($restricted_product_id_array, $restricted_product->product_id);
                }

                $result = $this->repo->getAvailableProducts($product_category_id,$restricted_product_id_array,$retailshop_township_id);

                if($result['aceplusStatusCode'] == ReturnMessage::OK){
                    $data = array();
                    $count = 0;

                    //add minimum_order_qty, maximum_order_qty, out_of_stock_flag
                    //all by default now
                    foreach($result['resultObjs'] as $result_product){
                      $result_product->minimum_order_qty = 1;
                      $result_product->maximum_order_qty = 50;
                      $result_product->out_of_stock_flag = 0;
                    }

                    //for out of stock testing
                    //temporary hard code
                    $result['resultObjs'][1]->out_of_stock_flag = 1;


                    $data[0]["products"] = $result['resultObjs'];

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

                  //get state and township id
                  // $retailshop_state_id = $retailshop->state_id;
                  $retailshop_township_id = $retailshop->township_id;

                  //get product detail including price
                  $result = $this->repo->getProductDetailByID($product_id,$retailshop_township_id);

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

                      // return \Response::json($returnedObj);
                      return \Response::json($returnedObj)->setEncodingOptions(JSON_NUMERIC_CHECK);
                  }
                  else{
                    $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                    $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
                    $returnedObj['data'] = [];
                    // return \Response::json($returnedObj);
                    return \Response::json($returnedObj)->setEncodingOptions(JSON_NUMERIC_CHECK);
                  }
                }
                //API parameter is missing
                else{
                  $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                  $returnedObj['aceplusStatusMessage'] = "Missing API Parameters";
                  $returnedObj['data'] = [];
                  // return \Response::json($returnedObj);
                  return \Response::json($returnedObj)->setEncodingOptions(JSON_NUMERIC_CHECK);
                }
            }
            catch (\Exception $e) {
                $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
                $returnedObj['aceplusStatusMessage'] = $e->getMessage() . " ----- line " . $e->getLine() . " ----- " . $e->getFile();
                $returnedObj['data'] = (object) array();
                // return \Response::json($returnedObj);
                return \Response::json($returnedObj)->setEncodingOptions(JSON_NUMERIC_CHECK);
            }
        }
        else{
            // return \Response::json($checkServerStatusArray);
            return \Response::json($checkServerStatusArray)->setEncodingOptions(JSON_NUMERIC_CHECK);
        }
    }
}
