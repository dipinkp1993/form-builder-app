<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:forms|max:255',
            'description' => 'nullable|string',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,email,number,select',
            'fields.*.options' => 'nullable|array',
        ];
    }
}
