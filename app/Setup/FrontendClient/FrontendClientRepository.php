<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 3:13 PM
 */

namespace App\Setup\FrontendClient;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Setup\FrontendClient\FrontendClient;
use App\Core\Utility;

class FrontendClientRepository implements FrontendClientRepositoryInterface
{
    public function getFrontendClient()
    {
        $backend = Backend::whereNull('deleted_at')->get();
        return $backend;
    }
    
    public function create($paramObj)
    {
        $tempObj = Utility::addCreatedBy($paramObj);
        $tempObj->save();
    }

    public function update($paramObj)
    {
        $tempObj = Utility::addUpdatedBy($paramObj);
        $tempObj->save();
    }

    public function delete($id)
    {
        if($id != 1){
            $tempObj = Backend::find($id);
            $tempObj = Utility::addDeletedBy($tempObj);
            $tempObj->deleted_at = date('Y-m-d H:m:i');
            $tempObj->save();
        }
    }

   
}