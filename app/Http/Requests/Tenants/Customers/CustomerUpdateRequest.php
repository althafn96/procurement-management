<?php

namespace App\Http\Requests\Tenants\Customers;

use App\Models\ClientCustomer;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit stakeholder');
    }

    public function rules()
    {
        // $id = $this->route('customer');
        // $customerUser = ClientCustomer::findOrFail($id)->user;

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            // 'email' => "required|email|unique:users,email,$customerUser->id"
            'email' => "required|email"
        ];
    }
}
