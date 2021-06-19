<?php

namespace App\Http\Requests\Tenants\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StaffUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit staff');
    }

    public function rules()
    {
        $id = $this->route('staff');

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "required|email|unique:users,email,$id"
        ];
    }
}
