<?php

namespace App\Http\Requests\UserRole;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit user role');
    }

    public function rules()
    {
        $id = $this->route('user_role');

        return [
            'role' => "required|alpha_num|unique:roles,name,$id",
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
