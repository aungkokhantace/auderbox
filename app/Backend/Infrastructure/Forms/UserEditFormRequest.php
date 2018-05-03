<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class UserEditFormRequest extends Request
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
            "display_name"      => "required",
            "user_name"         => "required|unique:core_users,user_name,".$this->get('id'),
            'email'             => "required|email|unique:core_users,email,".$this->get('id')
        ];
    }

    public function messages()
    {
        return [
            "user_name.required"        => "User Login Name is required",
            "display_name.required"     => "User Display Name is required",
            "email.required"            => "Email is required"
        ];
    }
}
