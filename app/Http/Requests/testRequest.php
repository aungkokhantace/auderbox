<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class testRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolf
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
            "type" => "required|alpha|unique",
            "description"=> "required",
            "discount_amount" => "required|numeric"

        ];
    }

    public function messages()
    {//create customize error messages
        return [
            'type.required' => 'Type is required',
            'description.required' => 'Description is required',
            'discount_amount.required' => 'Discount amount is required'

        ];
    }
}
