<?php
/**
 * Author: Aung Ko Khant
 * Date: 2018-05-03
 * Time: 3:30 PM
 */

namespace App\Http\Controllers\Api;

use App\Core\User\UserRepository;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use App\Backend\Infrastructure\Forms\LoginFormRequest;
use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use App\Session;
use App\Core\Check;
use App\Core\Redirect\AceplusRedirect;
use App\Core\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Input;
use App\Core\ReturnMessage;
use App\Api\Login\LoginApiRepository;
use App\Api\User\UserApiRepository;
use App\Api\RetailerProfile\RetailerProfileApiRepository;
use App\Core\Utility;
use App\Api\ShopList\ShopListApiRepository;

class LoginApiController extends Controller
{
    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:core_users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    //do login via api
    public function doLogin(){
      $temp                   = Input::All();
      $inputAll               = json_decode($temp['param_data']);
      $checkServerStatusArray = Check::checkCodes($inputAll);

      if($checkServerStatusArray['aceplusStatusCode'] == ReturnMessage::OK){
          $loginApiRepo = new LoginApiRepository();
          $userApiRepo  = new UserApiRepository();
          $retailerProfileApiRepo = new RetailerProfileApiRepository();
          $shopListApiRepo = new ShopListApiRepository();

          $login_attempt = $checkServerStatusArray['data'][0]->login_info;

          $validation = Auth::guard('User')->attempt([
              'phone_no'=>$login_attempt->phone_no,
              'password'=>$login_attempt->password,
              'role_id' =>5, //retailer role
              'status'  =>1,  //status is active
              'deleted_at'=>null //not deleted
          ]);

          if(!$validation){
            //unauthorized
            $returnedObj['aceplusStatusCode'] = ReturnMessage::UNAUTHORIZED;
            $returnedObj['aceplusStatusMessage'] = "Unauthorized request !";
            $returnedObj['data'] = (object) array();

            return \Response::json($returnedObj);
          }
          else{
              //login is valid
              //get login user information
              $user = $userApiRepo->getUserByPhoneNo($login_attempt->phone_no);
              $force_password_change = false;

              // check whether first time login or not
              if($user->first_login == 1){
                // if first login, flag is "true" to force user to change their OTP password
                $force_password_change = true;
              }

              $user_id = $user->id;

              $retailer_result = $retailerProfileApiRepo->getRetailerByUserId($user_id);

              if($retailer_result['aceplusStatusCode'] == ReturnMessage::OK){
                $retailerObj = $retailer_result['resultObj'];
              }
              else{
                $retailerObj = null;
              }

              //get cart item count
              $cart_item_count = Utility::getCartItemCount($retailerObj->retailer_id);

              //start retailshop
              $retailer_id = $retailerObj->retailer_id;
              $retailer_session = $retailerProfileApiRepo->getRetailerSessionByRetailerId($retailer_id);
              $retailshop_id = $retailer_session->retailshop_id;
              $retailshop_obj = $shopListApiRepo->getShopById($retailshop_id);
              //end retailshop

              //login request is successful and return login user id
              $returnedObj['aceplusStatusCode']       = ReturnMessage::OK;
              $returnedObj['aceplusStatusMessage']    = "Success!";
              $returnedObj['user_id']                 = $user->id;
              $returnedObj['retailer']                = $retailerObj;
              $returnedObj['retailshop']              = $retailshop_obj;
              $returnedObj['force_password_change']   = $force_password_change;
              $returnedObj['cart_item_count']         = $cart_item_count;

              return \Response::json($returnedObj);
          }
      }
      else{
          return \Response::json($checkServerStatusArray);
      }
    }

    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? Lang::get('auth.failed')
            : 'These credentials do not match our records.';
    }

    public function doLogout() //before logout, flush the session data
    {
        session()->flush();
        return redirect('/backend');
    }
}
