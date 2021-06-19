<?php

namespace App\Http\Requests\Tenants\CustomerOrganizations;

use Illuminate\Foundation\Http\FormRequest;

class CustomerOrganizationUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit customer organization');
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'nullable|email'
        ];
    }
}
