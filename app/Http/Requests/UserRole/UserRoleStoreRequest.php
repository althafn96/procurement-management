<?php

namespace App\Http\Requests\UserRole;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create user role');
    }

    public function rules()
    {
        return [
            'role' => 'required|unique:roles,name|alpha_num',
            'type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Unknown error occured. <br> Please reload page and try again.'
        ];
    }
}
