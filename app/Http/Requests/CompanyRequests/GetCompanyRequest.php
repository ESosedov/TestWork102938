<?php

namespace App\Http\Requests\CompanyRequests;

use Illuminate\Foundation\Http\FormRequest;

class GetCompanyRequest extends FormRequest
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
            'name' => 'string',
            'employee_id'=> 'int',
            'employee_name' => 'string',
            'employee_position' => 'string',
            'employee_status'=>'string',
            'sort_asc' => 'string|in:id,name',
            'sort_desc' => 'string|in:id,name',
            'limit' => 'int',
            'offset' => 'int',
        ];
    }
    public function messages()
    {
        return [
            'sort_asc.in' => 'Sort should be id, name',
            'sort_desc.in' => 'Sort should be id, name',

        ];
    }
}
