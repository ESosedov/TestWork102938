<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\Company\CompanyResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleEmployeeCompanyResource extends JsonResource
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
            'massage' => $this->when($request->isMethod('post'),
                'Created', 'OK'),
            'data' =>[
            'employee_id'=>$this->id,
            'name'=>$this->name,
            'position'=>$this->position,
            'companies'=>new CompanyResourceCollection($this->companies),
                ]

        ];
    }
}
