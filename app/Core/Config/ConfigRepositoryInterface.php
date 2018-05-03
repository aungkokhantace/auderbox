<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/28/2016
 * Time: 4:46 PM
 */
namespace App\Core\Config;

interface ConfigRepositoryInterface
{
    public function getSiteConfigs();
    public function updateSiteConfigs($id,$name,$description);
    public function getCompanyName();
    public function getCompanyLogo();
}