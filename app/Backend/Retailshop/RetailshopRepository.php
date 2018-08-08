<?php
namespace App\Backend\Retailshop;

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


/**
 * Author: Aung Ko Khant
 * Date: 2018-06-19
 * Time: 05:06 PM
 */

class RetailshopRepository implements RetailshopRepositoryInterface
{
  public function getObjByID($id){
    $result = Retailshop::find($id);
    return $result;
  }
}
