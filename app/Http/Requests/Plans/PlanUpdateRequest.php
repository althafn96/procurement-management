<?php

namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit plan');
    }

    public function rules()
    {
        $id = $this->route('plan')->id;

        return [
            'name' => "required|unique:plans,name,$id",
            'admins_count' => 'required|numeric'
        ];
    }
}
