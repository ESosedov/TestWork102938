<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\EmployeeRequests\AddCompanyToEmployeeRequest;
use App\Http\Requests\EmployeeRequests\CreateEmployeeRequest;
use App\Http\Requests\EmployeeRequests\DeleteCompanyFromEmployeeRequest;
use App\Http\Requests\EmployeeRequests\GetEmployeesRequest;
use App\Http\Resources\Employee\EmployeeCompanyResourceCollection;
use App\Http\Resources\Employee\SingleEmployeeCompanyResource;
use App\Repositories\Interfaces\Repository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @param Repository $employeeRepository
     */
    public function __construct(Repository $employeeRepository)
    {
        $this->repository = $employeeRepository;
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     *
     * @OA\POST(
     *     path="/employees",
     *     description="Add employee",
     *
     *     @OA\Parameter(
     *         description="Employee`s name",
     *         name="name",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Employee`s position",
     *         name="position",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Employee`s company",
     *         name="company_id",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *        @OA\Parameter(
     *         description="Employee`s status",
     *         name="status",
     *         in="query",
     *         required=with:company_id,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="201",
     *          description="Employee created"
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation failed"
     *     )
     * )
     */
    public function add(CreateEmployeeRequest $request)
    {
        $data = $request->validated();
        $employees = $this->repository->create($data);
        return new SingleEmployeeCompanyResource($employees);
    }

    /**
     * @param $employee_id
     * @return mixed
     *
     * @OA\GET(
     *     path="/employees/{employee_id}",
     *     description="Get employee by Id",
     *
     *     @OA\Parameter(
     *         description="ID of employee",
     *         in="path",
     *         name="employee_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *  @OA\Response(
     *          response="default",
     *          response="200",
     *          description="OK"
     *        ),
     *   @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *       )
     *  )
     *
     */
    public function detail($employee_id)
    {
        $employees = $this->repository->detail($employee_id);
        return new SingleEmployeeCompanyResource($employees);

    }

    /**
     * @param GetEmployeesRequest $request
     * @return mixed
     *
     * @OA\GET(
     *     path="/employees",
     *     description="Get employee by params",
     *
     *     @OA\Parameter(
     *         description="Employee`s name",
     *         name="name",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Employee`s position",
     *         name="position",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Company`s name",
     *         name="company_name",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Company`s id",
     *         name="company_id",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="Employee`s status",
     *         name="stutus,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="Sort employee ASC, should be id, name, position",
     *         name="sort_asc",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Sort employee DESC, should be id, name, position",
     *         name="sort_desc,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Offset",
     *         name="offset",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Limit",
     *         name="limit",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *    @OA\Response(
     *          response="422",
     *          description="Validation failed"
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="OK"
     *     )
     *
     * )
     */
    public function get(GetEmployeesRequest $request)
    {
        $data = $request->validated();
        $employees = $this->repository->get($data);

        return new EmployeeCompanyResourceCollection($employees);
    }


    /**
     * @param AddCompanyToEmployeeRequest $request
     * @param $employee_id
     * @return mixed
     *
     * @OA\Patch(
     *     path="/employees/{employee_id}/add_company",
     *     description="Set company to employee",
     *     @OA\Parameter(
     *         description="ID of employee to set company",
     *         in="path",
     *         name="employee_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *    @OA\Parameter(
     *         description="ID of company to set",
     *         in="query",
     *         name="company_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Employee`s status",
     *         name="status",
     *         in="query",
     *         required=with:company_id,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation failed"
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="Added company"
     *     )
     * )
     *
     */

    public function addCompany(AddCompanyToEmployeeRequest $request, $employee_id)
    {
        $data = $request->validated();
        $employees = $this->repository->addAttribute($employee_id, $data['company_id'], $data['status']);
        return new SingleEmployeeCompanyResource($employees);

    }

    /**
     * @param DeleteCompanyFromEmployeeRequest $request
     * @param $employee_id
     * @return mixed
     *
     * @OA\Patch(
     *     path="/employees/{employee_id}/delete_company",
     *     description="remove company by id from employee",
     *     @OA\Parameter(
     *         description="ID of employee to delete company",
     *         in="path",
     *         name="employee_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *    @OA\Parameter(
     *         description="ID of company to delete",
     *         in="query",
     *         name="company_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation failed"
     *     )
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="Deleted company"
     *
     */
    public function deleteCompany(DeleteCompanyFromEmployeeRequest $request, $employee_id)
    {
        $data = $request->validated();
        $employees = $this->repository->deleteAttribute($employee_id, $data['company_id']);
        return new SingleEmployeeCompanyResource($employees);
    }


    /**
     * @param $employee_id
     * @return mixed
     *
     * @OA\Delete(
     *     path="/employees/{employee_id}",
     *     description="Remove employee by id",
     *     @OA\Parameter(
     *         description="ID of employee to delete",
     *         in="path",
     *         name="employee_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="204",
     *          description="Deleted employee"
     *     )
     * )
     *
     */

    public function destroy($employee_id)
    {
        $this->repository->delete($employee_id,);
        return response(null, Response::HTTP_NO_CONTENT);
    }


}
