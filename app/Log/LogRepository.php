<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 12/28/2016
 * Time: 11:43 AM
 */

namespace App\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Setup\Backend\Backend;
use App\Setup\FrontEnd\FrontEnd;
use App\Setup\BackendLog\BackendLog;
use App\Setup\FrontEndLog\FrontEndLog;
use App\Core\ReturnMessage;
use App\Core\Utility;
use App\Log\LogRepositoryInterface;

class LogRepository implements LogRepositoryInterface
{
    public function getBackend()
    {
        //$backend = DB::select("SELECT * FROM backend_server WHERE deleted_at IS NULL");
        $backend = DB::select("SELECT * FROM backend_server");
        return $backend;
    }

    public function getBackendByIndex()
    {
        $backends = DB::select("SELECT * FROM backend_server");
        if(isset($backends) && count($backends)>0){
            $result = array();
            foreach ($backends as $index => $backend) {
                $result[$backend->id] = $backend;
            }
            return $result;
        }
        return array();
    }

    public function getFrontend()
    {
        $result = DB::select("SELECT * FROM front_end");
        return $result;
    }

    public function getFrontendByIndex()
    {
        $results = DB::select("SELECT * FROM front_end");
        if(isset($results) && count($results)>0){
            $frontend = array();
            foreach ($results as $index => $result) {
                $frontend[$result->id] = $result;
            }
            return $frontend;
        }
        return array();
    }

    public function getFrontendActiveCountByServer($backendId)
    {
        $resultArr = DB::select("SELECT count(id) AS frontendCount  FROM front_end WHERE backend_id = $backendId AND status = 'active'");
        $count = 0;
        if(isset($resultArr) && count($resultArr)>0){
            $count = $resultArr[0]->frontendCount;
        }
        return $count;
    }

    public function getFrontendInActiveCountByServer($backendId)
    {
        $resultArr = DB::select("SELECT count(id) AS frontendCount  FROM front_end WHERE backend_id = $backendId AND status = 'inactive'");
        $count = 0;
        if(isset($resultArr) && count($resultArr)>0){
            $count = $resultArr[0]->frontendCount;
        }
        return $count;
    }

    public function getFrontendAccessCount($frontendId)
    {
        $resultArr = DB::select("SELECT count(id) AS frontendCount  FROM front_end_client_log WHERE front_end_id = $frontendId");
        $count = 0;
        if(isset($resultArr) && count($resultArr)>0){
            $count = $resultArr[0]->frontendCount;
        }
        return $count;
    }

    public function getFrontendLog()
    {
        $result = DB::select("SELECT * FROM front_end_client_log");
        return $result;
    }

    public function getActivatingLog()
    {
        $backend = Backend::whereNull('deleted_at')->get();
        return $backend;
    }


}