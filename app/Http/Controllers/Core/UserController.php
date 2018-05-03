<?php
namespace App\Http\Controllers\Core;

use App\Backend\Infrastructure\Forms\UserEditFormRequest;
use App\Backend\Infrastructure\Forms\UserEntryFormRequest;
use App\Core\Role\Role;
use App\Core\Permission\Permission;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Core\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
    private
        $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('right');
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            //if (Auth::guard('User')->user()->role_id == 1) {
                $users      = $this->userRepository->getUsers();
                $roles      = $this->userRepository->getRoles();
                $cur_time   = Carbon::now();
                return view('core.user.index')->with('users', $users)->with('roles', $roles)->with('cur_time',
                    $cur_time);
            //}
        }
        return redirect('/backend/login');
    }

    public function create(){
        if (Auth::guard('User')->check()) {
            $roles = $this->userRepository->getRoles();
            return view('core.user.user')->with('roles', $roles);
        }
         return redirect('/backend/login');
    }

    public function store(UserEntryFormRequest $request)
    {
        $request->validate();
        $user_name       = trim(Input::get('user_name'));
        $display_name    = trim(Input::get('display_name'));
        $email    = trim(Input::get('email'));
        $password   = trim(bcrypt(Input::get('password')));
        $roleId     = Input::get('role_id');
        $address    = trim(Input::get('address'));

        $userObj = new User();
        $userObj->user_name = $user_name;
        $userObj->display_name = $display_name;
        $userObj->staff_id = $user_name;
        $userObj->email = $email;
        $userObj->password = $password;
        $userObj->role_id = $roleId;
        $userObj->address = $address;
        $this->userRepository->create($userObj);

        return redirect()->action('Core\UserController@index');
    }

    public function edit($id){
        if (Auth::guard('User')->check()) {
                $user = $this->userRepository->getObjByID($id);
                $roles = DB::table('core_roles')->get();
                return view('core.user.user')->with('user', $user)->with('roles', $roles);
        }
        return redirect('/backend/login');
    }

    public function update(UserEditFormRequest $request){

        $request->validate();
        $id                 = Input::get('id');
        $user_name          = Input::get('user_name');
        $display_name       = Input::get('display_name');
        $email              = Input::get('email');
        $address            = Input::get('address');
        $staffId            = Input::get('user_name');
        $roleId             = Input::get('role_id');

        $userObj            = User::find($id);
        $userObj->user_name = $user_name;
        $userObj->display_name = $display_name;
        $userObj->staff_id  = $staffId;
        $userObj->email     = $email;
        $userObj->role_id   = $roleId;
        $userObj->address   = $address;
        $password           = Input::get('password');

        if(isset($password) && $password != ""){
            $pwd = trim(bcrypt(Input::get('password')));
            $userObj->password = $pwd;
        }
        $this->userRepository->update($userObj);

        return redirect()->action('Core\UserController@index');
    }

    public function profile($id){
        if (Auth::guard('User')->check()) {
            $userSession = session('user');
            $loginUserId = $userSession['id'];

            if($id == $loginUserId){
                $user = $this->userRepository->getObjByID($id);
                $roles = DB::table('core_roles')->get();
                return view('core.user.user')->with('user', $user)->with('roles', $roles)->with('profile',true);
            }
            else{
                return redirect('errors/504');
            }

        }
        else{
            return redirect('unauthorize');
        }
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->userRepository->delete_users($id);
        }
        return redirect()->action('Core\UserController@index'); //to redirect listing page
    }

    public function getAuthUser() //after login, update status field 0 to 1
    {
        if (Auth::guard('User')->check()) {
            $id         = Auth::guard('User')->user()->id;
            $cur        = Carbon::now();
            $to         = Carbon::createFromFormat('Y-m-d H:i:s', $cur);
            $this->userRepository->changeDisableToEnable($id, $cur);
            $role       = DB::table('core_users')->find($id);

            if ($role->role_id == 1) {
                return redirect('/backend');
            } else if ($role->role_id == 2) {
                return redirect('/backend');
            } else {
                return redirect('/backend');
            }
        }
    }
}
