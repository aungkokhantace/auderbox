<?php
namespace App\Api\DeliveryDate;

use App\Core\ReturnMessage;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Backend\DeliveryRoute\DeliveryRoute;
use App\Backend\DeliveryRouteDay\DeliveryRouteDay;
use App\Backend\BrandOwnerDeliveryBlackoutDay\BrandOwnerDeliveryBlackoutDay;

/**
 * Author: Aung Ko Khant
 * Date: 2018-05-15
 * Time: 11:44 AM
 */

class DeliveryDateApiRepository implements DeliveryDateApiRepositoryInterface
{
    public function calculateDeliveryDate($brand_owner_id, $retailshop_id) {
      $returnedObj = array();
      $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

      try {
        //get brand owner delivery blackout day
        $blackout_days = BrandOwnerDeliveryBlackoutDay::select('date')
                                                        ->where('status',1)
                                                        ->whereNull('deleted_at')
                                                        ->get();

        $blackout_day_array = array();
        foreach($blackout_days as $blackout_day){
          array_push($blackout_day_array,$blackout_day->date);
        }

        $today_date = date('Y-m-d');
        $today_of_week = date('l',strtotime($today_date));
        $today_of_week_lower_case = strtolower($today_of_week);

        $delivery_route = DeliveryRoute::select('delivery_route.*')

                                          ->leftJoin('delivery_route_detail', 'delivery_route.id', '=', 'delivery_route_detail.delivery_route_id')

                                          ->where('delivery_route.brand_owner_id',$brand_owner_id)
                                          ->where('delivery_route_detail.retailshop_id',$retailshop_id)

                                          //get active records
                                          ->where('delivery_route.status',1)
                                          ->where('delivery_route_detail.status',1)

                                          ->first();

        if(!(isset($delivery_route) && count($delivery_route) > 0)){
          //no route, return error
          $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
          $returnedObj['aceplusStatusMessage'] = 'No delivery route for this request!';
        }
        else{
          $delivery_route_id = $delivery_route->id;

          //get delivery days of the route in array format
          $delivery_route_days = DeliveryRouteDay::select('delivery_route_day.monday',
                                                          'delivery_route_day.tuesday',
                                                          'delivery_route_day.wednesday',
                                                          'delivery_route_day.thursday',
                                                          'delivery_route_day.friday',
                                                          'delivery_route_day.saturday',
                                                          'delivery_route_day.sunday',
                                                          'delivery_route_day.deliver_today')
                                            ->where('delivery_route_id',$delivery_route_id)
                                            ->where('status',1) //get active records
                                            ->first()
                                            ->toArray(); //get in array format

          //get 'deliver_today' flag from query result
          $deliver_today_flag = $delivery_route_days['deliver_today'];

          //remove the last element (deliver_today flag)
          array_pop($delivery_route_days);

          $days_of_week_array = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

          $available_delivery_day_array = array();
          $available_delivery_day_count = 0;

          $available_delivery_route_lower_case_array = array();
          foreach($delivery_route_days as $key=>$value){
            if($value ==1){
              array_push($available_delivery_route_lower_case_array,$key);
            }
          }

          if((!in_array($today_date,$blackout_day_array)) &&
              ($deliver_today_flag == 1) &&
              (in_array($today_of_week_lower_case,$available_delivery_route_lower_case_array))) {

                $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
                $returnedObj['aceplusStatusMessage']  = "Request is successful!";
                $returnedObj['resultObj']             = $today_date;
                return $returnedObj;
          }

          foreach($delivery_route_days as $deli_day_key=>$deli_day_value){
            if($deli_day_value == 1){
              $available_day = "next ".ucwords($deli_day_key);
              $available_date = date('Y-m-d',strtotime($available_day));

              $blackout_flag = 0;
              if(in_array($available_date,$blackout_day_array)){
                $blackout_flag = 1;
              }

              $available_delivery_day_array[$available_delivery_day_count]['date'] = $available_date;
              $available_delivery_day_array[$available_delivery_day_count]['day']  = $deli_day_key;
              $available_delivery_day_array[$available_delivery_day_count]['blackout_flag']  = $blackout_flag;

              $available_delivery_day_count++;
            }
          }

          $no_blackout_delivery_days = array();
          foreach($available_delivery_day_array as $each_available_day){
            if($each_available_day['blackout_flag'] == 0){
              array_push($no_blackout_delivery_days,$each_available_day);
            }
          }

          foreach($no_blackout_delivery_days as $no_blackout_day){
              $available_date = $no_blackout_day['date'];
              $interval[] = abs(strtotime($today_date) - strtotime($available_date));
          }

          asort($interval);
          $closest = key($interval);

          $closet_delivery_date_obj = $no_blackout_delivery_days[$closest];
          $closet_delivery_date = $closet_delivery_date_obj['date'];
        }

        if(isset($closet_delivery_date) && count($closet_delivery_date)>0){
          $returnedObj['aceplusStatusCode']     = ReturnMessage::OK;
          $returnedObj['aceplusStatusMessage']  = "Request is successful!";
          $returnedObj['resultObj']             = $closet_delivery_date;
          return $returnedObj;
        }
        else{
          //if date does not exist
          $returnedObj['aceplusStatusMessage']  = "Delivery date does not exist!";
          return $returnedObj;
        }

      }
      catch(\Exception $e){
          $returnedObj['aceplusStatusMessage'] = $e->getMessage();
          return $returnedObj;
      }
    }
}
