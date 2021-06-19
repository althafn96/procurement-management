<?php

namespace App\Http\Requests\Tenants\Customers;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create stakeholder');
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            // 'password' => 'required'
        ];
    }
}
