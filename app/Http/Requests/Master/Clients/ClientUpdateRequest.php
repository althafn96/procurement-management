<?php

namespace App\Http\Requests\Master\Clients;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('edit client');
    }

    public function rules()
    {
        $id = $this->route('client');

        return [
            'company' => 'required',
            'plan_id' => 'required',
            'id' => 'required|regex:/^[A-Za-z0-9-.]+$/|unique:tenants,id,' . $id
        ];
    }

    public function messages()
    {
        return [
            'id.regex' => 'Application URL path is invalid',
            'address_flat_no.required' => 'Address (Flat no.) is required',
            'address_city.required' => 'City is required',
            'address_state.required' => 'State is required',
            'address_country.required' => 'Country is required'
        ];
    }
}