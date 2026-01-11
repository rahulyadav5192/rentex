<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return \Auth::user()->can('create property');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'mappings' => 'required|array',
            'mappings.*' => 'nullable|string',
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
        ];
    }
}

