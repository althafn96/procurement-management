<?php

namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;

class PlanStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create plan');
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:plans,name',
            'admins_count' => 'required|numeric',
        ];
    }
}
