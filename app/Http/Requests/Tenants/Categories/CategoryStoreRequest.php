<?php

namespace App\Http\Requests\Tenants\Categories;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create category');
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'code' => 'required|string'
        ];
    }
}
