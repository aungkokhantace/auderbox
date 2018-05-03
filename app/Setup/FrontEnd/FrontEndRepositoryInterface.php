<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 8/5/2016
 * Time: 2:27 PM
 */
namespace App\Setup\FrontEnd;

interface FrontEndRepositoryInterface
{
    public function getFrontEnd();
    public function getFrontEndByBackendId($backendId);
    public function update($paramObj);

}