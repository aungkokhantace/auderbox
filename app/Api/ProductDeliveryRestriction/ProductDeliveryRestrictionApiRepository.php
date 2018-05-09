<?php
namespace App\Api\ProductDeliveryRestriction;

use App\Core\ReturnMessage;
use App\Core\User\UserRepository;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\ProductCategory\ProductCategory;
use App\Backend\Product\Product;
use App\Backend\Retailshop\Retailshop;
use App\Backend\ProductDeliveryRestriction\ProductDeliveryRestriction;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-09
 * Time: 01:53 PM
 */

class ProductDeliveryRestrictionApiRepository implements ProductDeliveryRestrictionApiRepositoryInterface
{
    public function getRestrictedProductsByTownshipId($township_id){
      $restrictions = ProductDeliveryRestriction::where('township_id',$township_id)
                                                          ->where('status',1)  //get active restrictions
                                                          ->whereNull('deleted_at')
                                                          ->get();

      return $restrictions;
    }
}
