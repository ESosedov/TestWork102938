<?php
namespace App\Repositories;


use App\Models\Employee;
use App\Repositories\Interfaces\Repository;


class EmployeeRepository implements Repository
{

    public function create($data)
    {
        $employee = Employee::create($data);
        if(!empty($data['company_id'])) {
            $employee->companies()->attach($data['company_id'], ['status' => $data['status']]);
        }
        return $employee;
    }
    public function detail(int $employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        return $employee;
    }

    public function get(array $data)
    {
        $model = Employee::query();

        if (!empty($data['name'])) {
            $model->where('name', $data['name']);
        }

        if (!empty($data['position'])) {
            $model->where('position', $data['position']);
        }


        if (!empty($data['company_name'])) {

            $model->whereIn('id', function ($query) use ($data) {
                $query->select('employees.id',)
                    ->from('companies')
                    ->join('company_employee', 'companies.id', '=', 'company_employee.company_id')
                    ->join('employees', 'employees.id', '=', 'company_employee.employee_id')
                    ->where('companies.name', $data['company_name']);
            });
        }

        if (!empty($data['company_id'])) {

            $model->whereIn('id', function ($query) use ($data) {
                $query->select('employees.id',)
                    ->from('companies')
                    ->join('company_employee', 'companies.id', '=', 'company_employee.company_id')
                    ->join('employees', 'employees.id', '=', 'company_employee.employee_id')
                    ->where('companies.id', $data['company_id']);
            });
        }
        if (!empty($data['status'])) {

            $model->whereIn('id', function ($query) use ($data) {
                $query->select('employees.id',)
                    ->from('companies')
                    ->join('company_employee', 'companies.id', '=', 'company_employee.company_id')
                    ->join('employees', 'employees.id', '=', 'company_employee.employee_id')
                    ->where('company_employee.status', $data['status']);
            });
        }

        if(!empty($data['sort_asc'])){
            $model->orderBy($data['sort']);
        }
        if(!empty($data['sort_desc'])){
            $model->orderByDesc($data['sort_desc']);
        }


        $limit = $data['limit'] ?? 100;
        $offset = $data['offset'] ?? 0;

        return $model->offset($offset)->limit($limit)->get();
    }


    public function addAttribute($employee_id, $company_id, $status)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->companies()->attach($company_id,['status'=> $status]);
        return $employee;

    }

    public function deleteAttribute($employee_id, $company_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->companies()->detach($company_id);
        return $employee;

    }

    public function delete(int $employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->companies()->sync([]);
        $employee->delete();
        return $employee;
    }

}
