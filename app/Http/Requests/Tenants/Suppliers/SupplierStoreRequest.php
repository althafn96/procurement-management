<?php

namespace App\Http\Requests\Tenants\Suppliers;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create supplier');
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email'
        ];
    }
}
