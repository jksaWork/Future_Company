<?php


use App\Http\Controllers\School\School_CategoiresController;
use App\Http\Controllers\School\School_AllteachersController;
use App\Http\Controllers\School\School_AllowancesController;
use App\Http\Controllers\School\School_AttachmentController;
use App\Http\Controllers\School\School_TeachersAllowancesController;
use App\Http\Controllers\School\School_AdvancesController;
use App\Http\Controllers\School\School_SalariesController;
use App\Http\Controllers\School\School_SectionController;
use App\Http\Controllers\School\School_SpendingController;
use App\Http\Controllers\School\School_EmployeeSalariesController;
use App\Http\Controllers\School\School_DataController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\School_SettingController;
use App\Http\Controllers\School\School_ReportController;
use App\Http\Controllers\School\School_AchiveController;
use App\Http\Controllers\School\school_TypeController  as School_TypeController;

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
        Route::get('/section/{id}', [School_SpendingController::class, 'getproducts']);
        Route::get('/School_teachers/{id}', [School_AllteachersController::class, 'categories']);
        Route::get('/allowances/{id}', [School_AllteachersController::class, 'allowances']);
        Route::get('/teachers_id/{id}', [School_TeachersAllowancesController::class, 'teachers_id']);
        Route::get('/allowances_id/{id}', [School_TeachersAllowancesController::class, 'allowances_id']);
        Route::get('/teachers/{id}', [School_AdvancesController::class, 'teachers']);
        Route::get('/teachers_salaries/{id}', [School_SalariesController::class, 'teachers_salaries']);
        Route::get('/spendings/{id}', [School_ReportController::class, 'spendings']);
        // being Employee
        Route::middleware('auth:web')->group(function () {
            Route::prefix('School')->name('School.')->group(function () {
                //category routes

                Route::resource('school_type', School_TypeController::class)->except(['show']);
                Route::get('setting', [School_SettingController::class, 'index'])->name('setting');
                Route::post('setting', [School_SettingController::class, 'Store'])->name('setting.store');
                Route::resource('categories', School_CategoiresController::class)->except(['show']);
                Route::resource('All_Teachers', School_AllteachersController::class);
                Route::resource('allowances', School_AllowancesController::class)->except(['show']);
                Route::resource('Teachers_allowances', School_TeachersAllowancesController::class);
                Route::resource('Advances', School_AdvancesController::class);
                Route::resource('salaries', School_SalariesController::class);
                Route::resource('section', School_SectionController::class);
                Route::resource('spending', School_SpendingController::class);
                Route::get('print_spending/{id?}', [School_SpendingController::class, 'print_spending'])->name('spending.print');
                Route::get('print_salaries/{id?}', [School_SalariesController::class, 'print_salaries'])->name('salaries.print');
                Route::get('EmployeeSalaries', [School_SalariesController::class, 'EmployeeSalaries'])->name('EmployeeSalaries');
                Route::post('salaries_show', [School_SalariesController::class, 'salaries_show'])->name('salaries_show');

                Route::resource('Upload_attachment', School_AttachmentController::class);
                Route::get('Download_attachment/{studentsname}/{filename}', [School_AttachmentController::class, 'Download_attachment'])->name('Download_attachment');
                Route::post('Delete_attachment', [School_AttachmentController::class, 'Delete_attachment'])->name('Delete_attachment');
            });

            Route::prefix('data')->name('data.')->group(function () {

                Route::get('school_types-history-data', [School_DataController::class, 'school_typeshistoryData'])->name('school_types.hitory.data');
                Route::get('Section-history-data', [School_DataController::class, 'SectionhistoryData'])->name('Section.hitory.data');
                Route::get('spending-history-data', [School_DataController::class, 'spendinghistoryData'])->name('spending.hitory.data');
                Route::get('Category-history-data', [School_DataController::class, 'CategoryhistoryData'])->name('Category.hitory.data');
                Route::get('teachers-history-data', [School_DataController::class, 'teachershistoryData'])->name('teachers.hitory.data');
                Route::get('teachers_allowances-history-data', [School_DataController::class, 'teachers_allowanceshistoryData'])->name('teachers_allowances.hitory.data');
                Route::get('Advances-history-data', [School_DataController::class, 'AdvanceshistoryData'])->name('Advances.hitory.data');
                Route::get('salaries-history-data', [School_DataController::class, 'salarieshistoryData'])->name('salaries.hitory.data');
                Route::get('allowances-history-data', [School_DataController::class, 'allowanceshistoryData'])->name('allowances.hitory.data');
            });

            // Route::prefix('reports')->name('reports.')->group(function () {
            Route::prefix('School_reports')->name('School_reports.')->middleware(['auth:web'])->group(function () {
                Route::get('report_spending_data', [School_ReportController::class, 'report_spending_data'])->name('School_spending.report.data');
                Route::get('report_spending', [School_ReportController::class, 'report_spending'])->name('School_spending.report');
                Route::get('report_employee', [School_ReportController::class, 'report_employee'])->name('School_employee.report');
                Route::get('report_teachers', [School_ReportController::class, 'teachers'])->name('School_employee.report.data');
                Route::get('report_employee_allowances', [School_ReportController::class, 'report_employee_allowances'])->name('School_employee_allowances.report');
                Route::get('report_employee_allowances_data', [School_ReportController::class, 'report_employee_allowances_data'])->name('School_employee_allowances.report_data');
                Route::get('report_salaries', [School_ReportController::class, 'report_salaries'])->name('School_salaries.report');
                Route::get('report_salaries_data', [School_ReportController::class, 'report_salaries_data'])->name('School_salaries.report_data');

                Route::get('monthly-spending-renvues', [School_ReportController::class, 'MonthlyRealstateRenvueAndSpending'])->name('School_MonthlyRealstateRenvueAndSpending');
                Route::get('monthly-spending-data', [School_ReportController::class, 'MonthData'])->name('School_MonthData');
            });
            Route::prefix('School_Achive')->name('School_Achive.')->middleware(['auth:admin'])->group(function () {

                Route::get('Achive_section', [School_AchiveController::class, 'Achive_section'])->name('School_section.Achive');
                Route::get('Section-Achive', [School_AchiveController::class, 'SectionAchive'])->name('School_Section.Achives');
                Route::get('Section-Achive_feedback/{id}', [School_AchiveController::class, 'SectionAchiveFeedback'])->name('School_Section.Achives.feedback');


                Route::get('Achive_spending', [School_AchiveController::class, 'Achive_spending'])->name('School_spending.Achive');
                Route::get('spending-Achive', [School_AchiveController::class, 'spendingAchive'])->name('School_spending.Achives');
                Route::get('spending-Achive_feedback/{id}', [School_AchiveController::class, 'spendingAchiveFeedback'])->name('School_spending.Achives.feedback');


                Route::get('Achive_Category', [School_AchiveController::class, 'Achive_Category'])->name('School_Category.Achive');
                Route::get('Category-Achive', [School_AchiveController::class, 'CategoryAchive'])->name('School_Category.Achives');
                Route::get('Category-Achive_feedback/{id}', [School_AchiveController::class, 'CategoryAchiveFeedback'])->name('School_Category.Achives.feedback');


                Route::get('Achive_allowances', [School_AchiveController::class, 'Achive_allowances'])->name('School_allowances.Achive');
                Route::get('allowances-Achive', [School_AchiveController::class, 'allowancesAchive'])->name('School_allowances.Achives');
                Route::get('allowances-Achive_feedback/{id}', [School_AchiveController::class, 'allowancesAchiveFeedback'])->name('School_allowances.Achives.feedback');



                Route::get('Achive_employee', [School_AchiveController::class, 'Achive_employee'])->name('School_employee.Achive');
                Route::get('employee-Achive', [School_AchiveController::class, 'employeeAchive'])->name('School_employee.Achives');
                Route::get('employee-Achive_feedback/{id}', [School_AchiveController::class, 'employeeAchiveFeedback'])->name('School_employee.Achives.feedback');



                Route::get('Achive_employee_allowances', [School_AchiveController::class, 'Achive_employee_allowances'])->name('School_employee_allowances.Achive');
                Route::get('employee_allowances-Achive', [School_AchiveController::class, 'employee_allowancesAchive'])->name('School_employee_allowances.Achives');
                Route::get('employee_allowances-Achive_feedback/{id}', [School_AchiveController::class, 'employee_allowancesAchiveFeedback'])->name('School_employee_allowances.Achives.feedback');


                Route::get('Achive_Advances', [School_AchiveController::class, 'Achive_Advances'])->name('School_Advances.Achive');
                Route::get('Advances-Achive', [School_AchiveController::class, 'AdvancesAchive'])->name('School_Advances.Achives');
                Route::get('Advances-Achive_feedback/{id}', [School_AchiveController::class, 'AdvancesAchiveFeedback'])->name('School_Advances.Achives.feedback');


                Route::get('Achive_salaries', [School_AchiveController::class, 'Achive_salaries'])->name('School_salaries.Achive');
                Route::get('salaries-Achive', [School_AchiveController::class, 'salariesAchive'])->name('School_salaries.Achives');
                Route::get('salaries-Achive_feedback/{id}', [School_AchiveController::class, 'salariesAchiveFeedback'])->name('School_salaries.Achives.feedback');
            });
            Route::get('Teachers-status/{id}', [School_DataController::class, 'ChangeStatus'])->name('Teachers.status');
        });
    }

);