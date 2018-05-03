<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 12/28/2016
 * Time: 11:39 AM
 */

namespace App\Log;

interface LogRepositoryInterface
{
    public function getBackend();
    public function getBackendByIndex();
    public function getFrontend();
    public function getFrontendByIndex();
    public function getFrontendActiveCountByServer($backendId);
    public function getFrontendInActiveCountByServer($backendId);
    public function getFrontendAccessCount($frontendId);
    public function getActivatingLog();
}