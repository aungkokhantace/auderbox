<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class UserEntryFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name'          => 'required|string|unique:core_users',
            'display_name'  => 'required|string',
            'email'         => "required|email|unique:core_users",
            'password'      => 'required|min:8',
            'conpassword'   => 'required|same:password',
            'role_id'      => 'required'
        ];
    }
    public function messages()
    {
        return [
            'user_name.required'         => 'User Login Name is required!',
            'display_name.required' => 'User Display Name is required',
            'email.required'        => 'Email is required',
            'password.required'     => 'Password is required',
            'conpassword.required'  => 'Confirm Password is required',
            'conpassword.same'      => 'Password and Confirm Password must match',
            'role_id.required'     => 'Staff Role is required'
        ];
    }
}
