<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFormRequest extends FormRequest
{
    protected $formId;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('forms')->ignore($this->formId),
            ],
            'description' => 'nullable|string',
            'fields.*.id' => 'sometimes',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,email,number,select',
            'fields.*.options' => 'nullable|array',
        ];
    }

    protected function prepareForValidation()
    {
        $this->formId = $this->route('id');
    }
}
