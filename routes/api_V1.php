<?php


use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\EmployeeController;
use Illuminate\Support\Facades\Route;




Route::group(['prefix'=>'employees', 'middleware' => 'auth_api'], function() {
    Route::get('/', [EmployeeController::class, 'get']);
    Route::post('/', [EmployeeController::class, 'add' ]);
    Route::patch('/{employee_id}/add_company', [EmployeeController::class, 'addCompany' ])->where(['employee_id' => '[0-9]+']);
    Route::patch('/{employee_id}/delete_company', [EmployeeController::class, 'deleteCompany' ])->where(['employee_id' => '[0-9]+']);
    Route::delete('/{employee_id}', [EmployeeController::class, 'destroy' ])->where(['employee_id' => '[0-9]+']);
    Route::get('/{employee_id}', [EmployeeController::class, 'detail' ])->where(['employee_id' => '[0-9]+']);


});

Route::group(['prefix'=>'companies', 'middleware' => 'auth_api'], function(){
    Route::get('/', [CompanyController::class, 'get']);
    Route::post('/', [CompanyController::class, 'add' ]);
    Route::patch('/{company_id}/add_employee', [CompanyController::class, 'addEmployee' ])->where(['company_id' => '[0-9]+']);
    Route::patch('/{company_id}/delete_employee', [CompanyController::class, 'deleteEmployee' ])->where(['company_id' => '[0-9]+']);
    Route::delete('/{company_id}', [CompanyController::class, 'destroy' ])->where(['company_id' => '[0-9]+']);
    Route::get('/{company_id}', [CompanyController::class, 'detail' ])->where(['company_id' => '[0-9]+']);
});
