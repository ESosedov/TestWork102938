<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\Company\CompanyResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'employee_id'=>$this->id,
            'name'=>$this->name,
            'position'=>$this->position,
            'companies'=>new CompanyResourceCollection($this->companies),


        ];
    }
}
