<?php

namespace App\Http\Requests\Master\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit contact');
    }

    public function rules()
    {
        $id = $this->route('contact')->id;

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|unique:contacts,email,$id|unique:users,email"
        ];
    }
}
