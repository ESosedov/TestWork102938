<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Employee\EmployeeResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyEmployeeResource extends JsonResource
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

            'company_id' => $this->id,
            'company_name' => $this->name,
            'employees' => new EmployeeResourceCollection($this->employees)

        ];
    }
}
