<?php

namespace App\Backend\Infrastructure\Forms;

use App\Http\Requests\Request;

class StaffTyeEditRequest extends Request
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "name" =>"required",
            "description" => "required"
        ];
    }
    public function messages(){
        return [
            "name.required" => "Role Name is required",
            "description.required" => "Description is required"
        ];
    }
}
