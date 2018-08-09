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
            ['code'=>'DEFAULT_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'6','description'=>'Number of digits in default id without prefix'],
            ['code'=>'INVOICE_DETAIL_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'3','description'=>'Number of digits in invoice detail id without prefix'],
            ['code'=>'INVOICE_DETAIL_HISTORY_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'3','description'=>'Number of digits in invoice detail history id without prefix'],
            ['code'=>'INVOICE_SESSION_ID_PAD_LENGTH', 'type'=>'SETTING', 'value'=>'6','description'=>'Number of digits in invoice session id without prefix'],
            ['code'=>'TAX_PERCENTAGE', 'type'=>'SETTING', 'value'=>'0','description'=>'Tax Percentage'],
            ['code'=>'SHOW_EQUAL_QTY_TO_PROMOTION', 'type'=>'SETTING', 'value'=>'0','description'=>'Alert when purchase qty is equal to promotion qty'],
            ['code'=>'SHOW_GREATER_QTY_THAN_PROMOTION', 'type'=>'SETTING', 'value'=>'1','description'=>'Alert when purchase qty is greater than promotion qty'],
            ['code'=>'SHOW_LESS_QTY_THAN_PROMOTION', 'type'=>'SETTING', 'value'=>'1','description'=>'Alert when purchase qty is less than promotion qty'],
            ['code'=>'CONTACT_PHONE_NUMBER', 'type'=>'SETTING', 'value'=>'09899043432','description'=>'Contact phone number'],
            ['code'=>'MAX_ORDER_QTY', 'type'=>'SETTING', 'value'=>'100000','description'=>'Maximum quantity that a user can order'],

        );

        DB::table('core_configs')->insert($roles);
    }
}
