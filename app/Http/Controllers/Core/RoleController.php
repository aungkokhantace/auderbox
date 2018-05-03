<?php
namespace App\Http\Controllers\Core;

use App\Core\User\UserRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\StaffTypeRequest;
use App\Backend\Infrastructure\Forms\StaffTyeEditRequest;
use App\Core\Role\RoleRepositoryInterface;
use App\Core\Role\Role;
use App\Core\Permission\Permission;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Core\Permission\PermissionRole;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            $roles      = $this->roleRepository->getRoles();
            return view('core.role.index')->with('roles', $roles);
        }
        return redirect('/backend/login');
    }

    public function create(){
        if (Auth::guard('User')->check()) {
            return view('core.role.role');
        }
        return redirect('/backend/login');
    }

    public function store(StaffTypeRequest $request)
    {
        $request->validate();
        $name           = Input::get('name');
        $description    = Input::get('description');

        $role = new Role();
        $role->name = $name;
        $role->description = $description;

        $this->roleRepository->create($role);
        return redirect()->action('Core\RoleController@index');
    }

    public function edit($id){
        if (Auth::guard('User')->check()) {
            $roles = $this->roleRepository->getObjByID($id);
            return view('core.role.role')->with('roles', $roles);
        }
        return redirect('/backend/login');
    }

    public function update(StaffTyeEditRequest $request){
        $id             = Input::get('id');
        $name           = Input::get('name');
        $description    = Input::get('description');

        $role = Role::find($id);
        $role->name = $name;
        $role->description = $description;

        $this->roleRepository->update($role);
        return redirect()->action('Core\RoleController@index');
    }

    public function destroy(){
        $id         = Input::get('selected_checkboxes');
        $new_string = explode(',', $id);
        foreach($new_string as $id){
            $this->roleRepository->delete($id);
        }
        return redirect()->action('Core\RoleController@index');
    }

    public function rolePermission($id)
    {
        if (Auth::guard('User')->check()) {
            $role = $this->roleRepository->getObjByID($id);
            $rolePermissions = $this->roleRepository->getRolePermissions($id);
            return view('core.role.rolePermission')->with('role',$role)->with('features_permissions',$rolePermissions);
        }
        return redirect('/backend/login');
    }

    public function rolePermissionAssign($rid)
    {
        $inputs = Input::all();
        if(isset($inputs['module'])) {
            $fId = $inputs['module'];
        }
        else {
            return redirect()->action('Core\RoleController@index');
        }

        $temp_current_permissions_id = $this->roleRepository->getPermissionsByRoleId($rid);

        $current_permissions_id = [];
        if(count($temp_current_permissions_id)> 0) {
            foreach($temp_current_permissions_id as $key=>$v) {
                $current_permissions_id[$key] = $v->permission_id;
            }

        }

        foreach($inputs as $key=>$value)
        {
            $is_permission_added_in_current_role = false;
            if($key == '_token') continue;
            if($key == 'module') continue;
            $permission_id = explode("_", $key) [1];
            $is_permission_added_in_current_role = in_array($permission_id, $current_permissions_id);

            $existedPermission = $this->roleRepository->getPermissionsRoleByRoleIdNPermissionId($rid,$permission_id);

            if(!$is_permission_added_in_current_role && $value == 'on')
            {
                //echo 'ON'; print_r ($current_permissions_id); echo $permission_id.'->'; echo $is_permission_added_in_current_role; echo '<br>';
                //if the permission is not exist, create new permission role record.

                if(isset($existedPermission) && count($existedPermission)>0) {
                    if($this->roleRepository->updatePermissionsRoleByRoleIdNPermissionId($rid,$permission_id)) {
                        return Redirect::to('/roles/' . $rid)
                            ->withMessage(FormatGenerator::message('Error', 'Update Fail!'));
                    }
                    else{

                    }
                }
                else{
                    $new_permission = new PermissionRole();
                    $new_permission->role_id = $rid;
                    $new_permission->permission_id = $permission_id;
                    $new_permission->save();
                }
            }
            //if permission is in the current role, but it was turn off.
            else if($is_permission_added_in_current_role)
            {
                if($value == 'off'){

                    //if permission record is exist (true), find and do a delete.
                    $perm = PermissionRole::where('role_id', $rid)->where('permission_id', $permission_id)->first();

                    if(isset($perm)){
                        $perm->delete();
                    }
                    //else it is not exist, do nothing.
                }
                else if($value == 'on')
                {
                    //echo 'ON'; print_r ($current_permissions_id); echo $permission_id.'->'; echo $is_permission_added_in_current_role; echo '<br>';
                    //do nothing ....
                }
            }
        }

        // Change User's Session Permissions
        $sessionUser = session('user');
        $userId = $sessionUser['id'];
        $userRepository = new UserRepository();
        $permissions = $userRepository->getPermissionByUserId($userId);
        session(['permissions' => ""]);
        session(['permissions' => $permissions]);

        return redirect()->action('Core\RoleController@index');
    }

}
