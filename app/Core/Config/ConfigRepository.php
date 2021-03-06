<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/28/2016
 * Time: 4:51 PM
 */

namespace App\Core\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Core\Config\Config;

class ConfigRepository implements ConfigRepositoryInterface
{
    public function getSiteConfigs()
    {
        $configs = Config::whereNull('deleted_at')->get();
        return $configs;
    }

    public function updateSiteConfigs($id,$name,$description){
        $configs = Config::whereNull('deleted_at')->get();
        return $configs;
    }

    public function getCompanyName()
    {
        $tbConfig =  (new Config())->getTable();
        $configs = DB::select("SELECT * FROM $tbConfig WHERE code = 'SETTING_COMPANY_NAME'");
        return $configs;
    }

    public function getCompanyLogo()
    {
        $tbConfig =  (new Config())->getTable();
        $configs = DB::select("SELECT * FROM $tbConfig WHERE code = 'SETTING_LOGO'");
        return $configs;
    }

    public function getSiteActivationKey()
    {
        $tbConfig =  (new Config())->getTable();
        $configs = DB::select("SELECT * FROM $tbConfig WHERE code = 'SETTING_SITE_ACTIVATION_KEY'");
        return $configs;
    }

    public function getInvoicePrefixId()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'INVOICE_ID_PREFIX'");
        return $configs;
    }

    public function getInvoiceIdPadLength()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'INVOICE_ID_PAD_LENGTH'");
        return $configs;
    }

    public function getInvoiceDetailIdPadLength()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'INVOICE_DETAIL_ID_PAD_LENGTH'");
        return $configs;
    }

    public function getInvoiceDetailHistoryIdPadLength()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'INVOICE_DETAIL_HISTORY_ID_PAD_LENGTH'");
        return $configs;
    }

    public function getTaxPercentage()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'TAX_PERCENTAGE'");
        if(isset($configs) && count($configs) > 0){
          return $configs[0]->value;
        }
        return 0;
    }

    public function getTaxAmount()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'TAX_AMOUNT'");
        if(isset($configs) && count($configs) > 0){
          return $configs;
        }
        return 0;
    }

    public function getInvoiceSessionIdPadLength()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'INVOICE_SESSION_ID_PAD_LENGTH'");
        return $configs;
    }

    public function getAlertFlagForPromoQty($param_code)
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = '$param_code'");
        if(isset($configs) && count($configs)>0){
          return $configs[0]->value;
        }
        return 1;
    }

    public function getDefaultIdPadLength()
    {
        $tbConfig =  (new Config())->getTable();
        $configs  = DB::select("SELECT * FROM $tbConfig WHERE code = 'DEFAULT_ID_PAD_LENGTH'");
        if(isset($configs) && count($configs)>0){
          return $configs[0]->value;
        }
        return 6;
    }
}
