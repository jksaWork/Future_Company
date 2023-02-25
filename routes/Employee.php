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
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
              Route::resource('categories', CategoiresController::class)->except(['show']);
              Route::resource('All_Employee', AllEmployeeController::class);
              Route::resource('allowances', AllowancesController::class)->except(['show']);
              Route::resource('employee_allowances', EmployeeAllowancesController::class);
              Route::resource('Advances', AdvancesController::class);
              Route::resource('salaries', SalariesController::class);
              Route::resource('section', SectionController::class);
              Route::resource('spending', SpendingController::class);
            //   Route::resource('EmployeeSalaries', EmployeeSalariesController::class);
              Route::post('salaries_show', [SalariesController::class ,'salaries_show'])->name('salaries_show');

              Route::resource('Upload_attachment', AttachmentController::class);
              Route::get('Download_attachment/{studentsname}/{filename}', [AttachmentController::class ,'Download_attachment'])->name('Download_attachment');
              Route::post('Delete_attachment', [AttachmentController::class ,'Delete_attachment'])->name('Delete_attachment');
        });

        Route::prefix('Salaries')->name('Salaries.')->group(function () {
            Route::get('Salaries-data' ,[EmployeeSalariesController::class , 'data'])->name('data');
        });
    }
);
