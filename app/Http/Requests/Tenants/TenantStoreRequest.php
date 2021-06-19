<?php

namespace App\Http\Requests\Tenants;

use Illuminate\Foundation\Http\FormRequest;

class TenantStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create client');
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'package_id' => 'required',
            'id' => 'required|alpha_dash|unique:clients,id',
            'admin_email' => 'required|email',
            'admin_password' => 'required'
        ];
    }
}
