<?php

namespace App\Http\Requests\EmployeeRequests;

use Illuminate\Foundation\Http\FormRequest;

class GetEmployeesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'position' => 'string',
            'status'=>'string',
            'company_id'=> 'int',
            'company_name' => 'string',
            'sort_asc' => 'string|in:id,name,position',
            'sort_desc' => 'string|in:id,name,position',
            'limit' => 'int',
            'offset' => 'int',
        ];
    }
    public function messages()
    {
        return [
            'sort_asc.in' => 'Sort should be id, name, position',
            'sort_desc.in' => 'Sort should be id, name, position',

        ];
    }
}
