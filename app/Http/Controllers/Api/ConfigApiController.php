<?php

/**
 * Author: Aung Ko Khant
 * Date: 2018-06-25
 * Time: 01:53 PM
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Session;
use App\Core\Check;
use App\Core\Redirect\AceplusRedirect;
use Illuminate\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Core\Config\ConfigRepository;
use App\Core\StatusConstance;
use App\Core\CoreConstance;
use Illuminate\Support\Facades\DB;
use App\Api\Config\ConfigApiRepository;
use App\Api\Config\ConfigApiRepositoryInterface;

class ConfigApiController extends Controller
{
  public function __construct(ConfigApiRepositoryInterface $repo)
  {
      $this->repo = $repo;
  }

  public function getContactPhoneNumber() {
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);

    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
      $returnedObj['data'] = [];

      $contact_phone_number = $this->repo->getContactPhoneNumber();

      if (isset($contact_phone_number) && count($contact_phone_number) > 0) {

        $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
        $returnedObj['aceplusStatusMessage']  = "Success, contact phone number is downloaded successfully!";
        $returnedObj['contact_phone_number']  = $contact_phone_number;
        return \Response::json($returnedObj);
      }
      else{
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
        return \Response::json($returnedObj);
      }
    }
    else{
        return \Response::json($checkServerStatusArray);
    }
  }
}
