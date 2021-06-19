<?php

namespace App\Http\Requests\Tenants\OpportunityRequests;

use Illuminate\Foundation\Http\FormRequest;

class OpportunityRequestStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create opportunity request');
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'category_id' => 'required'
        ];
    }
}
