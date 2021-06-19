<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit staff');
    }

    public function rules(Request $request)
    {
        $id = $this->route('staff');

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "required|email|unique:users,email,$id"
        ];
    }
}
