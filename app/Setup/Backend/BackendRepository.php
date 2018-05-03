<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 10/21/2016
 * Time: 10:15 AM
 */

namespace App\Setup\Backend;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Setup\Backend\Backend;
use App\Setup\FrontEnd\FrontEnd;
use App\Setup\BackendLog\BackendLog;
use App\Setup\FrontEndLog\FrontEndLog;
use App\Core\ReturnMessage;
use App\Core\Utility;

class BackendRepository implements BackendRepositoryInterface
{
    public function getBackend()
    {
        $backend = Backend::whereNull('deleted_at')->get();
        return $backend;
    }
    
    public function create($paramObj)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $backend_id      = $paramObj->id;
            $count   = $paramObj->client_count;
            $des     = $paramObj->description;
            $status  = $paramObj->status;

            //Save Backend Server Log
            $backend_log = new BackendLog();
            $backend_log->backend_id = $backend_id;
            $backend_log->description ="created";

            $log = Utility::addCreatedBy($backend_log);
            $log->save();

            for($c=1; $c <= $count; $c++ ){
                $paramObj                = new FrontEnd();
                $paramObj->backend_id    = $backend_id;
                $generateActivationKey= uniqid();
                $paramObj->activation_key= md5($generateActivationKey);
                $paramObj->description   = $des;
                $paramObj->status        = $status;

                $temp                    = Utility::addCreatedBy($paramObj);
                $temp ->save();

                //Save Front End Server Log
                $id = $paramObj->id;
                $fronted_log = new FrontEndLog();
                $fronted_log->front_end_id = $id;
                $fronted_log->description = "created";

                $log = Utility::addCreatedBy($fronted_log);
                $log->save();
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function update($paramObj)
    {

        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {

            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $backend_id      = $paramObj->id;
            $count   = $paramObj->client_count;
            $des     = $paramObj->description;
            $status  = $paramObj->status;

            //Save Backend Server Log
            $backend_log = new BackendLog();
            $backend_log->backend_id = $backend_id;
            $backend_log->description ="created";

            $log = Utility::addCreatedBy($backend_log);
            $log->save();

            for($c=1; $c<=$count; $c++){

                $paramObj = FrontEnd::where('backend_id','=',$id)->first();
                $paramObj->description = $des;
                $paramObj->status      = $status;

                $tempObj = Utility::addUpdatedBy($paramObj);
                $tempObj->save();

                //Save Front End Server Log
                $id = $paramObj->id;
                $fronted_log = new FrontEndLog();
                $fronted_log->front_end_id = $id;
                $fronted_log->description = "created";

                $log = Utility::addCreatedBy($fronted_log);
                $log->save();
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function detailUpdate($paramObj,$new_client)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        try {

            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $backend_id      = $paramObj->id;
            $des     = $paramObj->description;
            $status  = $paramObj->status;

            //Save Backend Server Log
            $backend_log = new BackendLog();
            $backend_log->backend_id = $backend_id;
            $backend_log->description ="Add New Client Count";

            $log = Utility::addCreatedBy($backend_log);
            $log->save();

            for($c=1; $c<=$new_client; $c++){
                $paramObj                = new FrontEnd();
                $paramObj->backend_id    = $backend_id;
                $generateActivationKey  = uniqid();
                $paramObj->activation_key = md5($generateActivationKey);
                $paramObj->description   = $des;
                $paramObj->status        = $status;

                $temp                    = Utility::addCreatedBy($paramObj);
                $temp ->save();

                //Save Front End Server Log
                $id = $paramObj->id;
                $fronted_log = new FrontEndLog();
                $fronted_log->front_end_id = $id;
                $fronted_log->description = "adding new client count created";

                $log = Utility::addCreatedBy($fronted_log);
                $log->save();
            }

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function myfunction($value,$key)
    {
        echo "The key $key has the value $value<br>";
    }

}