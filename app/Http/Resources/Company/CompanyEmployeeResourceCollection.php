<?php

namespace App\Http\Resources\Company;


use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyEmployeeResourceCollection extends ResourceCollection
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
