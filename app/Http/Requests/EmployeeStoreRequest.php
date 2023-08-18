<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
//            'name' => 'required|string|max:255',
//            'position' => 'string|max:255',
//            'hire_date' => 'nullable|date',
//            'phone_number' => ['required', 'string', 'max:20', 'regex:/^\+380\d{9}$/u'],
//            'email' => 'required|string|email|max:255',
//            'salary' => ['required', 'numeric', 'between:0,9999999.99'],
//            'photo' => 'nullable|image|max:2048',
        ];
    }

}
