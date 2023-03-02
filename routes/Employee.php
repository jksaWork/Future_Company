<?php


use App\Http\Controllers\Employee\CategoiresController;
use App\Http\Controllers\Employee\AllEmployeeController;
use App\Http\Controllers\Employee\AllowancesController;
use App\Http\Controllers\Employee\AttachmentController;
use App\Http\Controllers\Employee\EmployeeAllowancesController;
use App\Http\Controllers\Employee\AdvancesController;
use App\Http\Controllers\Employee\SalariesController;
use App\Http\Controllers\Employee\SectionController;
use App\Http\Controllers\Employee\SpendingController;
use App\Http\Controllers\Employee\EmployeeSalariesController;
use App\Http\Controllers\Employee\DataController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Employee\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        // being Employee
       Route::prefix('Employee')->name('Employee.')->middleware(['auth:admin'])->group(function () {
        //category routes

        
        Route::get('setting', [SettingController::class, 'index'])->name('setting');
        Route::post('setting', [SettingController::class, 'Store'])->name('setting.store');
              Route::resource('categories', CategoiresController::class)->except(['show']);
              Route::resource('All_Employee', AllEmployeeController::class);
              Route::resource('allowances', AllowancesController::class)->except(['show']);
              Route::resource('employee_allowances', EmployeeAllowancesController::class);
              Route::resource('Advances', AdvancesController::class);
              Route::resource('salaries', SalariesController::class);
              Route::resource('section', SectionController::class);
              Route::resource('spending', SpendingController::class);
            //   Route::resource('EmployeeSalaries', EmployeeSalariesController::class);
            Route::get('EmployeeSalaries', [SalariesController::class , 'EmployeeSalaries'])->name('EmployeeSalaries');
              Route::post('salaries_show', [SalariesController::class ,'salaries_show'])->name('salaries_show');

              Route::resource('Upload_attachment', AttachmentController::class);
              Route::get('Download_attachment/{studentsname}/{filename}', [AttachmentController::class ,'Download_attachment'])->name('Download_attachment');
              Route::post('Delete_attachment', [AttachmentController::class ,'Delete_attachment'])->name('Delete_attachment');
        });

        Route::prefix('Section')->name('Section.')->group(function () {


                Route::get('Section-history-data', [DataController::class , 'SectionhistoryData'])->name('Section.hitory.data');
                Route::get('spending-history-data', [DataController::class , 'spendinghistoryData'])->name('spending.hitory.data');
                Route::get('Category-history-data', [DataController::class , 'CategoryhistoryData'])->name('Category.hitory.data');
                Route::get('employees-history-data', [DataController::class , 'employeeshistoryData'])->name('employees.hitory.data');
                Route::get('employee_allowances-history-data', [DataController::class , 'employee_allowanceshistoryData'])->name('employee_allowances.hitory.data');
                Route::get('Advances-history-data', [DataController::class , 'AdvanceshistoryData'])->name('Advances.hitory.data');
                Route::get('salaries-history-data', [DataController::class , 'salarieshistoryData'])->name('salaries.hitory.data');
                Route::get('allowances-history-data', [DataController::class , 'allowanceshistoryData'])->name('allowances.hitory.data');
        });
        
        // Route::prefix('reports')->name('reports.')->group(function () {
            Route::prefix('reports')->name('reports.')->middleware(['auth:admin'])->group(function () {

            Route::get('report_spending', [ReportController::class , 'report_spending'])->name('spending.report');
            Route::get('report_employee', [ReportController::class , 'report_employee'])->name('employee.report');
            Route::get('report_employee_allowances', [ReportController::class , 'report_employee_allowances'])->name('employee_allowances.report');
        });



        Route::get('employees-status/{id}', [DataController::class , 'ChangeStatus'])->name('employees.status');

    }
);
