<?php

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
use App\Api\Invoice\InvoiceApiRepositoryInterface;

class InvoiceApiController extends Controller
{
  public function __construct(InvoiceApiRepositoryInterface $repo)
  {
      $this->repo = $repo;
  }

  public function upload(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];
      
        $returnedObj['data']= [];
        if (isset($params->invoices) && count($params->invoices) > 0) {

          $result = $this->repo->uploadInvoice($params->invoices);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
              $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage'] = "Success!";
              return \Response::json($returnedObj);
          }
          else{
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
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

  public function getInvoiceList(){
    $temp                   = Input::All();
    $inputAll               = json_decode($temp['param_data']);
    $checkServerStatusArray = Check::checkCodes($inputAll);

    if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
        $params             = $checkServerStatusArray['data'][0];

        $returnedObj['data']= [];
        if (isset($params->invoice_list) && count($params->invoice_list) > 0) {
          // dd('invoice_list',$params->invoice_list);

          $retailer_id  = $params->invoice_list->retailer_id;
          $filter       = $params->invoice_list->filter;

          $result = $this->repo->getInvoiceList($retailer_id,$filter);

          if($result['aceplusStatusCode'] == ReturnMessage::OK){
              $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage'] = "Success!";
              return \Response::json($returnedObj);
          }
          else{
            $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
            $returnedObj['aceplusStatusMessage'] = $result['aceplusStatusMessage'];
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
