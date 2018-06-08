<?php namespace App\Core;
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 7/12/2016
 * Time: 3:27 PM
 */

use App\Core\Config\ConfigRepository;
use Validator;
use Auth;
use DB;
use App\Http\Requests;
use App\Session;
use App\Core\User\UserRepository;
use App\Core\SyncsTable\SyncsTable;

class Utility
{

    public static function addCreatedBy($newObj)
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            $userSession = session('user');
            $loginUserId = $userSession['id'];
            $newObj->updated_by = $loginUserId;
            $newObj->created_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function addUpdatedBy($newObj)
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            $userSession = session('user');
            $loginUserId = $userSession['id'];
            $newObj->updated_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function addDeletedBy($newObj)
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            $userSession = session('user');
            $loginUserId = $userSession['id'];
            $newObj->deleted_by = $loginUserId;
        }
        Utility::updateSyncsTable($newObj);
        return $newObj;
    }

    public static function updateSyncsTable($newObj)
    {
        $table_name = $newObj->getTable();
        $tempSyncTable = new SyncsTable();
        $syncTableName = $tempSyncTable->getTable();

        $syncTableObj = DB::table($syncTableName)
            ->select('*')
            ->where('table_name' , '=' , $table_name)
            ->first();

        if(isset($syncTableObj) && count($syncTableObj)>0) {
            $id = $syncTableObj->id;
            $version = $syncTableObj->version + 1;
            $syncTable = SyncsTable::find($id);

            $sessionObj = session('user');
            if (isset($sessionObj)) {
                $userSession = session('user');
                $loginUserId = $userSession['id'];
                $syncTable->updated_by = $loginUserId;
            }

            $syncTable->version = $version++;
            $syncTable->save();
        }
    }

    /*
    //without pad_length
    public static function generate_id($prefix,$table,$col,$offset){
        $idStringArray  = DB::select("SELECT `$col` as id FROM `$table` WHERE id LIKE '$prefix%'");
        $unique         = str_pad(1, 6, "0", STR_PAD_LEFT);
        // dd(max(['INV20180521000001','INV20180521000002','INV20180521000003','INV20180521000011','INV20180521000012','INV20180521000013','INV20180521000100','INV20180521000101','INV20180521000300','INV20180521001000']));
        if(count($idStringArray) > 0){
          $temp_arr = [];
          foreach($idStringArray as $idString){
            array_push($temp_arr,$idString->id);
          }
          $max_str_id   = max($temp_arr);
          $length       = strrpos($max_str_id,'0')+1;
          $split_str    = str_split($max_str_id,$length);
          $number       = $split_str[1]+1;
          $unique       = str_pad($number, 6, "0", STR_PAD_LEFT);
        }
        return sprintf("%s%s",$prefix,$unique);
    }
    */

    //with $pad_length
    public static function generate_id($prefix,$table,$col,$offset, $pad_length = 6)
    {
        $max = DB::select("SELECT MAX(`$col`) as id FROM `$table` WHERE id LIKE '$prefix%'");
        $newId = 1;
        if($max[0] != null && $max[0]->id != null) {
            $oldId = $max[0]->id;
            $numberPart = str_replace($prefix,"",$oldId);
            $value = intval($numberPart);
            $newId = $value + $offset;
        }
        $runningNo = str_pad($newId, $pad_length, 0, STR_PAD_LEFT);
        return sprintf("%s%s",$prefix,$runningNo);
    }

    public static function getCurrentUserID(){
        $id = Auth::guard('User')->user()->id;
        return $id;
    }

    public static function getCartItemCount($retailer_id){
      $cart_items = DB::table('invoice_session')
                        ->where('retailer_id',$retailer_id)
                        ->get();

      $cart_item_count = 0;
      foreach($cart_items as $cart_item) {
        $cart_item_count += $cart_item->quantity;
      }
      
      return $cart_item_count;
    }
}
