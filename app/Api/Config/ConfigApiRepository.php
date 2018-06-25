<?php
namespace App\Api\Config;
use App\User;
use App\Api\User\UserApiRepositoryInterface;
use App\Core\ReturnMessage;
use App\Core\User\UserRepository;
use App\Core\Utility;
use Illuminate\Support\Facades\DB;
use App\Core\Config\Config;

/**
 * Author: Aung Ko Khant
 * Date: 2018-06-25
 * Time: 01:55 PM
 */

class ConfigApiRepository implements ConfigApiRepositoryInterface
{
    public function getContactPhoneNumber() {
      $tbConfig =  (new Config())->getTable();
      $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'CONTACT_PHONE_NUMBER'");
      if(isset($configs) && count($configs)>0){
        return $configs[0]->value;
      }
      return "09899043432";
    }
}
