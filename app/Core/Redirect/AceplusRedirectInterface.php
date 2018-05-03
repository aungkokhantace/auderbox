<?php namespace App\Core\Redirect;
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/30/2016
 * Time: 2:52 PM
 */

interface AceplusRedirectInterface {

    public function firstRedirect();
    public function firstRedirectPath();
    public function afterAuthedRedirect();
}