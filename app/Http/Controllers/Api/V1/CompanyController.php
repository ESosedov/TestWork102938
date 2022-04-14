<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\CompanyRequests\AddEmployeeToCompanyRequest;
use App\Http\Requests\CompanyRequests\CreateCompanyRequest;
use App\Http\Requests\CompanyRequests\DeleteEmployeeFromCompanyRequest;
use App\Http\Requests\CompanyRequests\GetCompanyRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company\CompanyEmployeeResourceCollection;
use App\Http\Resources\Company\SingleCompanyEmployeeResource;
use App\Repositories\Interfaces\Repository;
use Illuminate\Http\Response;


class CompanyController extends Controller
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @param Repository $companyRepository
     */
    public function __construct(Repository $companyRepository)
    {
        $this->repository = $companyRepository;
    }

    /**
     * @param CreateCompanyRequest $request
     * @return mixed
     *
     * @OA\POST(
     *     path="/companies",
     *     description="Add company",
     *
     *     @OA\Parameter(
     *         description="Company`s name",
     *         name="name",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),

     *      @OA\Parameter(
     *         description="Employee of company",
     *         name="employee_id",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *        @OA\Parameter(
     *         description="Employee`s status in company",
     *         name="employee_status",
     *         in="query",
     *         required=with:employee_id,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="201",
     *          description="Company created"
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation failed"
     *     )
     * )
     */
    public function add(CreateCompanyRequest $request)
    {
        $data = $request->validated();
        $companies = $this->repository->create($data);
        return new SingleCompanyEmployeeResource($companies);
    }

    /**
     * @param $company_id
     * @return mixed
     *
     *  @OA\GET(
     *     path="/companies/{company_id}",
     *     description="Get company by Id",
     *
     *     @OA\Parameter(
     *         description="ID of company",
     *         in="path",
     *         name="company_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *    @OA\Response(
     *          response="default",
     *          response="200",
     *          description="OK"
     *        ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found",
     *        )
     *  )
     *
     */

    public function detail($company_id)
    {
        $companies = $this->repository->detail($company_id);
        return new SingleCompanyEmployeeResource($companies);

    }

    /**
     * @param GetCompanyRequest $request
     * @return mixed
     *
     * @OA\GET(
     *     path="/companies",
     *     description="Get company by params",
     *
     *     @OA\Parameter(
     *         description="Company`s name",
     *         name="name",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Employee`s name in company",
     *         name="employee_name",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Employee`s id in company",
     *         name="employee_id",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *       @OA\Parameter(
     *         description="Employee`s position in company",
     *         name="employee_position,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="Employee`s status in company",
     *         name="employee_status,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="Sort company ASC, should be id, name",
     *         name="sort_asc",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Sort company DESC, should be id, name",
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
     *     )
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="OK"
     *     )
     *
     * )
     */
    public function get(GetCompanyRequest $request)
    {
        $data = $request->validated();
        $companies = $this->repository->get($data);

        return new CompanyEmployeeResourceCollection($companies);

    }

    /**
     * @param AddEmployeeToCompanyRequest $request
     * @param $company_id
     * @return mixed
     *
     * @OA\Patch(
     *     path="/companies/{company_id}/add_employee",
     *     description="Set employee to company",
     *     @OA\Parameter(
     *         description="ID of company to set employee",
     *         in="path",
     *         name="company_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *    @OA\Parameter(
     *         description="ID of employee to set",
     *         in="query",
     *         name="employee_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="Employee`s status",
     *         name="status",
     *         in="query",
     *         required=with:employee_id,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Company not found",
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation failed"
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="Added employee"
     *     )
     * )
     */
    public function addEmployee(AddEmployeeToCompanyRequest $request, $company_id)
    {
        $data = $request->validated();
        $companies = $this->repository->addAttribute($company_id, $data['employee_id'], $data['status']);
        return new SingleCompanyEmployeeResource($companies);

    }

    /**
     * @param DeleteEmployeeFromCompanyRequest $request
     * @param $company_id
     * @return mixed
     *
     * @OA\Patch(
     *     path="/companies/{company_id}/delete_employee",
     *     description="Delete employee from company",
     *     @OA\Parameter(
     *         description="ID of company to delete employee",
     *         in="path",
     *         name="company_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *    @OA\Parameter(
     *         description="ID of employee to delete",
     *         in="query",
     *         name="employee_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Company not found",
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation failed"
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="Deleted employee"
     *     )
     * )
     */
    public function deleteEmployee(DeleteEmployeeFromCompanyRequest $request, $company_id)
    {

        $data = $request->all();
        $companies = $this->repository->deleteAttribute($company_id,$data['employee_id']);
        return new SingleCompanyEmployeeResource($companies);

    }

    /**
     * @param $company_id
     * @return mixed
     *
     * @OA\Delete(
     *     path="/companies/{company_id}",
     *     description="Remove company by id",
     *     @OA\Parameter(
     *         description="ID of company to delete",
     *         in="path",
     *         name="company_id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comapny not found",
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="204",
     *          description="Deleted company"
     *     )
     * )
     */
    public function destroy($company_id)
    {
        $this->repository->delete($company_id,);
        return response(null,Response::HTTP_NO_CONTENT);
    }

}
