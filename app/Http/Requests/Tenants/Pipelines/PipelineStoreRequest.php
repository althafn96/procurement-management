<?php

namespace App\Http\Requests\Tenants\Pipelines;

use Illuminate\Foundation\Http\FormRequest;

class PipelineStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create pipeline');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'project_id' => 'required'
        ];
    }
}
