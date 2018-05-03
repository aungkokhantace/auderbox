<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 6/20/2016
 * Time: 3:56 PM
 */

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class PermissionEditRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "name" =>"required",
            "module" =>"required",
            "url" => "required"
        ];
    }
    public function messages(){
        return [
            "name.required" => "Role Name is required",
            "module.required" => "Module is required",
            "url.required" => "URL is required"
        ];
    }
}
