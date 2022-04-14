<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeCompanyResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'massage' => $this->when($request->isMethod('post'),
                'Created', 'OK'),
            'data' => $this->collection

        ];
    }
}
