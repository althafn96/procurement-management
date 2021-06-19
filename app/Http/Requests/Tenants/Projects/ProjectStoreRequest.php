<?php

namespace App\Http\Requests\Tenants\Projects;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create project');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->status == 'Accepted') {
            return [
                'title' => 'required|string',
                'category_id' => 'required',
                'assigned_staff_id' => 'required'
            ];
        } else {
            return [];
        }
    }
}
