<?php

namespace App\Http\Requests\CompanyRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:companies|max:255',
            'employee_id' => 'int|required_with:status',
            'status' => 'string|required_with:employee_id'
        ];
    }
}
