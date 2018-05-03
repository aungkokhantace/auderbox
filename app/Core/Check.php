<?php namespace App\Core;
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 10/25/2016
 * Time: 10:42 AM
 */
use App\Core\Config\ConfigRepository;
use Validator;
use Auth;
use App\Http\Requests;
use App\Session;
use App\Core\User\UserRepository;
use App\Setup\FrontedClient\FrontedClient;
use App\Setup\Backend\Backend;
class Check
{
    /**
     *
     * @return bool
     */
    public static function validSession()
    {
        $sessionObj = session('user');
        if(isset($sessionObj)){
            return true;
        }
        return false;
    }

    public static function hasPermission($permissions,$routeAction) {

        if(isset($permissions) && count($permissions)>0) {
            foreach ($permissions as $key => $permission) {
                if ($permission['url'] == $routeAction) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $methodString
     * @param $method
     * @return bool
     */
    public static function hasMethods($methodString,$method) {
        $methods = explode('|', $methodString);
        return (in_array("*", $methods) || in_array($method, $methods));
    }

     /**
     * @return mixed
     */
    public static function logout() {
        //flush session
        Session::flush();

        //redirect user to login page
        return Redirect::to('/backend/login');
    }

    public static function getInfo() {
        $info = array();
        $info['companyName'] = "";
        if(Check::validSession()) {
            $info['userName'] = strtoupper(session('user')['user_name']);
            $info['userId'] = session('user')['id'];
            $info['userRoleId'] = session('user')['role_id'];
        }
        return $info;
    }

    public static function companyLogo() {

        $ConfigRepository = new ConfigRepository();
        $companyLogo = $ConfigRepository->getCompanyLogo();

        if(isset($companyLogo) && count($companyLogo)>0 ) {

            if(isset($companyLogo[0]->value) && $companyLogo[0]->value != ""){
                return $companyLogo[0]->value;
            }
            else{
                return "/images/aceplus-logo.png";
            }
        }
        return "/images/aceplus-logo.png";
    }

    public static function companyName() {

        $ConfigRepository = new ConfigRepository();
        $companyName = $ConfigRepository->getCompanyName();

        if(isset($companyName) && count($companyName)>0 ) {

            if(isset($companyName[0]->value) && $companyName[0]->value != ""){
                return $companyName[0]->value;
            }
            else{
                return "AcePlus Backend";
            }
        }
        return "AcePlus Backend";
    }

    public static function createSession($id) {

        $userRepository = new UserRepository();
        $tempUser = $userRepository->getObjByID($id);
        $permissions = $userRepository->getPermissionByUserId($id);
        session(['user'=>$tempUser->toArray()]);
        session(['permissions' => $permissions]);
    }

}