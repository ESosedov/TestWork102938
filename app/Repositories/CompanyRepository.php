<?php

namespace App\Repositories;


use App\Models\Company;
use App\Repositories\Interfaces\Repository;


class CompanyRepository implements Repository
{

    public function create($data)
    {
        $company = Company::create($data);
        if (!empty($data['employee_id'])) {
            $company->employees()->attach($data['employee_id'], ['status' => $data['status']]);
        }
        return $company;
    }

    public function detail(int $company_id)
    {
        $company = Company::findOrFail($company_id);
        return $company;
    }

    public function get(array $data)
    {
        $model = Company::query();

        if (!empty($data['name'])) {
            $model->where('name', $data['name']);
        }


        if (!empty($data['employee_name'])) {

            $model->whereIn('id', function ($query) use ($data) {
                $query->select('companies.id',)
                    ->from('employees')
                    ->join('company_employee', 'employees.id', '=', 'company_employee.employee_id')
                    ->join('companies', 'companies.id', '=', 'company_employee.company_id')
                    ->where('employees.name', $data['employee_name']);
            });
        }
        if (!empty($data['employee_id'])) {

            $model->whereIn('id', function ($query) use ($data) {
                $query->select('companies.id',)
                    ->from('employees')
                    ->join('company_employee', 'employees.id', '=', 'company_employee.employee_id')
                    ->join('companies', 'companies.id', '=', 'company_employee.company_id')
                    ->where('employees.id', $data['employee_id']);
            });
        }
        if (!empty($data['employee_position'])) {

            $model->whereIn('id', function ($query) use ($data) {
                $query->select('companies.id',)
                    ->from('employees')
                    ->join('company_employee', 'employees.id', '=', 'company_employee.employee_id')
                    ->join('companies', 'companies.id', '=', 'company_employee.company_id')
                    ->where('employees.position', $data['employee_position']);
            });
        }
        if (!empty($data['employee_status'])) {

            $model->whereIn('id', function ($query) use ($data) {
                $query->select('companies.id',)
                    ->from('employees')
                    ->join('company_employee', 'employees.id', '=', 'company_employee.employee_id')
                    ->join('companies', 'companies.id', '=', 'company_employee.company_id')
                    ->where('company_employee.status', $data['employee_status']);
            });
        }

        if(!empty($data['sort_asc'])){
            $model->orderBy($data['sort_asc']);
        }
        if(!empty($data['sort_desc'])){
            $model->orderByDesc($data['sort_desc']);
        }


        $limit = $data['limit'] ?? 100;
        $offset = $data['offset'] ?? 0;

        return $model->offset($offset)->limit($limit)->get();
    }


    public function addAttribute($company_id, $employee_id, $status)
    {
        $company = Company::findOrFail($company_id);
        $company->employees()->attach($employee_id, ['status' => $status]);
        return $company;

    }

    public function deleteAttribute($company_id, $employee_id)
    {
        $company = Company::findOrFail($company_id);
        $company->employees()->detach($employee_id);
        return $company;

    }

    public function delete(int $company_id)
    {
        $company = Company::findOrFail($company_id);
        $company->employees()->sync([]);
        $company->delete();
        return $company;
    }

}
