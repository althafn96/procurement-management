<?php

namespace App\Http\Requests\Master\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create contact');
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:contacts,email|unique:users,email'
        ];
    }
}
