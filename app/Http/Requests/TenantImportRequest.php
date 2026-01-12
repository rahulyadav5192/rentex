<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return \Auth::user()->can('create tenant');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'mappings' => 'required|array',
            'mappings.*' => 'nullable|string',
            'property_selections' => 'sometimes|array',
            'property_selections.*' => 'nullable|integer|exists:properties,id',
            'unit_selections' => 'sometimes|array',
            'unit_selections.*' => 'nullable|integer|exists:property_units,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages()
    {
        return [
            'mappings.required' => __('Column mappings are required.'),
            'mappings.array' => __('Mappings must be an array.'),
            'property_selections.array' => __('Property selections must be an array.'),
            'unit_selections.array' => __('Unit selections must be an array.'),
        ];
    }
}

