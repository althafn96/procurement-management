<?php

namespace App\Http\Requests\Tenants\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StaffStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create staff');
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required'
        ];
    }
}
