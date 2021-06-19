<?php

namespace App\Http\Requests\Tenants\CustomerOrganizations;

use Illuminate\Foundation\Http\FormRequest;

class CustomerOrganizationStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create customer organization');
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'nullable|email'
        ];
    }
}
