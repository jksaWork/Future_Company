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
use App\Http\Controllers\Employee\AchiveController;

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
              Route::get('print_spending/{id?}', [SpendingController::class , 'print_spending'])->name('spending.print');
              Route::get('print_salaries/{id?}', [SalariesController::class , 'print_salaries'])->name('salaries.print');
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
            Route::get('report_salaries', [ReportController::class , 'report_salaries'])->name('salaries.report');
        });
        Route::prefix('Achive')->name('Achive.')->middleware(['auth:admin'])->group(function () {

            Route::get('Achive_section', [AchiveController::class , 'Achive_section'])->name('section.Achive');
            Route::get('Section-Achive', [AchiveController::class , 'SectionAchive'])->name('Section.Achives');
            Route::get('Section-Achive_feedback/{id}', [AchiveController::class , 'SectionAchiveFeedback'])->name('Section.Achives.feedback');


            Route::get('Achive_spending', [AchiveController::class , 'Achive_spending'])->name('spending.Achive');
            Route::get('spending-Achive', [AchiveController::class , 'spendingAchive'])->name('spending.Achives');
            Route::get('spending-Achive_feedback/{id}', [AchiveController::class , 'spendingAchiveFeedback'])->name('spending.Achives.feedback');
        

            Route::get('Achive_Category', [AchiveController::class , 'Achive_Category'])->name('Category.Achive');
            Route::get('Category-Achive', [AchiveController::class , 'CategoryAchive'])->name('Category.Achives');
            Route::get('Category-Achive_feedback/{id}', [AchiveController::class , 'CategoryAchiveFeedback'])->name('Category.Achives.feedback');
        
        
            Route::get('Achive_allowances', [AchiveController::class , 'Achive_allowances'])->name('allowances.Achive');
            Route::get('allowances-Achive', [AchiveController::class , 'allowancesAchive'])->name('allowances.Achives');
            Route::get('allowances-Achive_feedback/{id}', [AchiveController::class , 'allowancesAchiveFeedback'])->name('allowances.Achives.feedback');
        

            
            Route::get('Achive_employee', [AchiveController::class , 'Achive_employee'])->name('employee.Achive');
            Route::get('employee-Achive', [AchiveController::class , 'employeeAchive'])->name('employee.Achives');
            Route::get('employee-Achive_feedback/{id}', [AchiveController::class , 'employeeAchiveFeedback'])->name('employee.Achives.feedback');
        
        
            
            Route::get('Achive_employee_allowances', [AchiveController::class , 'Achive_employee_allowances'])->name('employee_allowances.Achive');
            Route::get('employee_allowances-Achive', [AchiveController::class , 'employee_allowancesAchive'])->name('employee_allowances.Achives');
            Route::get('employee_allowances-Achive_feedback/{id}', [AchiveController::class , 'employee_allowancesAchiveFeedback'])->name('employee_allowances.Achives.feedback');
        
         
            Route::get('Achive_Advances', [AchiveController::class , 'Achive_Advances'])->name('Advances.Achive');
            Route::get('Advances-Achive', [AchiveController::class , 'AdvancesAchive'])->name('Advances.Achives');
            Route::get('Advances-Achive_feedback/{id}', [AchiveController::class , 'AdvancesAchiveFeedback'])->name('Advances.Achives.feedback');
        

            Route::get('Achive_salaries', [AchiveController::class , 'Achive_salaries'])->name('salaries.Achive');
            Route::get('salaries-Achive', [AchiveController::class , 'salariesAchive'])->name('salaries.Achives');
            Route::get('salaries-Achive_feedback/{id}', [AchiveController::class , 'salariesAchiveFeedback'])->name('salaries.Achives.feedback');
        
        });
        Route::get('employees-status/{id}', [DataController::class , 'ChangeStatus'])->name('employees.status');

    }
);
