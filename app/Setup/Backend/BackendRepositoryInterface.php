<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 10/21/2016
 * Time: 10:13 AM
 */
namespace App\Setup\Backend;

interface BackendRepositoryInterface
{
    public function getBackend();
    public function create($paramObj);
    public function update($paramObj);
    public function detailUpdate($paramObj,$new_client);
    public function myfunction($value,$key);
}