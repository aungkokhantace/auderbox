<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-07
 * Time: 3:49 PM
 */

namespace App\Http\Controllers\Api;

use App\Core\User\UserRepository;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Backend\Infrastructure\Forms\LoginFormRequest;
use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use App\Session;
use App\Core\Check;
use App\Core\Redirect\AceplusRedirect;
use App\Core\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\Api\Login\LoginApiRepository;
use App\Api\User\UserApiRepository;
use App\Api\ShopList\ShopListApiRepositoryInterface;
use App\Api\ShopList\ShopListApiRepository;

class ShopListApiController extends Controller
{
    public function __construct(ShopListApiRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getShopList(){
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          $params             = $checkServerStatusArray['data'][0];

          if (isset($params->retailshops) && count($params->retailshops) > 0) {
            $retailer_id = $params->retailshops->retailer_id;

            $result = $this->repo->getShopsByRetailerId($retailer_id);

            if($result['aceplusStatusCode'] == ReturnMessage::OK){
                $data = array();
                $count = 0;
                $data[0]["retailshops"] = $result['resultObjs'];

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
      else{
          return \Response::json($checkServerStatusArray);
      }
    }

    public function selectRetailshop(){
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          $params             = $checkServerStatusArray['data'][0];

          if (isset($params->select_retailshop) && count($params->select_retailshop) > 0) {
            $retailer_id = $params->select_retailshop->retailer_id;
            $retailshop_id = $params->select_retailshop->retailshop_id;

            $result = $this->repo->saveSelectedShop($retailer_id,$retailshop_id);

            if($result['aceplusStatusCode'] == ReturnMessage::OK){
                $returnedObj['aceplusStatusCode']     = $result['aceplusStatusCode'];
                $returnedObj['aceplusStatusMessage']  = $result['aceplusStatusMessage'];
                $returnedObj['data']                  = [];

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
      else{
          return \Response::json($checkServerStatusArray);
      }
    }
}
