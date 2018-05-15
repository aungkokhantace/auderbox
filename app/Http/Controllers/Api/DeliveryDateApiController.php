<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-14
 * Time: 04:45 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use App\Session;
use App\Core\Check;
use App\Core\Redirect\AceplusRedirect;
use Illuminate\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\Api\DeliveryDate\DeliveryDateApiRepositoryInterface;

class DeliveryDateApiController extends Controller
{
    public function __construct(DeliveryDateApiRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getDeliveryDate(){
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          $params             = $checkServerStatusArray['data'][0];

          if (isset($params->delivery_date) && count($params->delivery_date) > 0) {
            $brand_owner_id = $params->delivery_date->brand_owner_id;
            $retailshop_id  = $params->delivery_date->retailshop_id;

            $result = $this->repo->calculateDeliveryDate($brand_owner_id,$retailshop_id);

            if($result['aceplusStatusCode'] == ReturnMessage::OK){
                $delivery_date = $result['resultObj'];

                $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
                $returnedObj['aceplusStatusMessage'] = "Success!";
                $returnedObj['data'] = $delivery_date;

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
