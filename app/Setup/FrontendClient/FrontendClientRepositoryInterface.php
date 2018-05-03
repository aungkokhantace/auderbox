<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 3:13 PM
 */
namespace App\Setup\FrontendClient;

interface FrontendClientRepositoryInterface
{
    public function getFrontendClient();
    public function delete($id);
    public function create($paramObj);
    public function update($paramObj);
   
}