<?php

namespace App\Http\Requests\Tenants\Suppliers;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit supplier');
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
