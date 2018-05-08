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
use App\Api\RetailerProfile\RetailerProfileApiRepositoryInterface;
use App\Api\RetailerProfile\RetailerProfileApiRepository;

class RetailerProfileApiController extends Controller
{
    public function __construct(RetailerProfileApiRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    //do login via api
    public function getRetailerProfile(){
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          $params             = $checkServerStatusArray['data'][0];

          if (isset($params->user_profile) && count($params->user_profile) > 0) {
            $user_id = $params->user_profile->id;
            $result = $this->repo->getRetailerById($user_id);

            if($result['aceplusStatusCode'] == ReturnMessage::OK){
                $data = array();
                $count = 0;
                $data[0]["user_profile"] = $result['resultObj'];

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
      }
      else{
          return \Response::json($checkServerStatusArray);
      }
    }
}
