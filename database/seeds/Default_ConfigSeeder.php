<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:18 PM
 */
use Illuminate\Database\Seeder;

class Default_ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_configs')->delete();

        $roles = array(
            ['code'=>'SETTING_COMPANY_NAME', 'type'=>'SETTING', 'value'=>'AcePlus Backend','description'=>'Company Name'],
            ['code'=>'SETTING_LOGO', 'type'=>'SETTING', 'value'=>'/images/logo.jpg','description'=>'Company Logo'],
            ['code'=>'SETTING_SITE_ACTIVATION_KEY', 'type'=>'SETTING', 'value'=>'1234567','description'=>'Site Activation Key'],
            ['code'=>'INVOICE_ID_PREFIX', 'type'=>'SETTING', 'value'=>'INV','description'=>'Default Prefix Id'],
            ['code'=>'INVOICE_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'6','description'=>'Number of digits in invoice id without prefix'],
            ['code'=>'INVOICE_DETAIL_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'3','description'=>'Number of digits in invoice detail id without prefix'],
            ['code'=>'INVOICE_DETAIL_HISTORY_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'3','description'=>'Number of digits in invoice detail history id without prefix'],
            ['code'=>'INVOICE_SESSION_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'6','description'=>'Number of digits in invoice session id without prefix'],

        );

        DB::table('core_configs')->insert($roles);
    }
}
