<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AreaController as AdminAreaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RentController;
// use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AgentAuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AssingOrderToClientController;
use App\Http\Controllers\AttachmentsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FinanicalTreasuryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RealStateCategoryController;
use App\Http\Controllers\RealStateController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', [DashboardController::class, 'getIndex']);
Route::get('/switch', fn () => 'jksa')->name('switchLan');
Route::get('/pro', fn () => 'jksa')->name('profile');
Route::middleware('auth')->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('home', [AdminHomeController::class, 'index'])->name('home');

        // role  -----------------
        // Route::get('role/data' , [RoleController::class , 'data'])->name('roles.data');
        // Route::resource('roles' , RoleController::class);
        // Route::delete('bulk_delete', fn()=> '')->name('roles.bulk_delete');

        // Admins Data  -----------------------
        Route::get('admin/data', [AdminController::class, 'data'])->name('admins.data');
        Route::resource('admin', AdminController::class);
        Route::delete('admin/bulk_delete', fn () => '')->name('admin.bulk_delete');

        // Admins Data  -----------------------
        Route::get('user/data', [AdminUsersController::class, 'data'])->name('user.data');
        Route::resource('user', AdminUsersController::class);
        Route::delete('user/bulk_delete', fn () => '')->name('user.bulk_delete');
        Route::get('setting', [SettingController::class, 'index'])->name('setting');
        Route::post('setting', [SettingController::class, 'Store'])->name('setting.store');
    });
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        //  New Route Login
        Route::prefix('admin')->middleware('guest:admin')->group(function () {
            Route::get('login', [AdminAuthController::class, 'getlogin'])->name('admin.get_login');
            Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
        });


        Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
            Route::get('role/data', [RoleController::class, 'data'])->name('roles.data');
            Route::resource('roles', RoleController::class);
            Route::delete('bulk_delete', fn () => '')->name('roles.bulk_delete');
        });
        Route::middleware('auth:admin,web')->group(function () {
            // Owners Resource
            Route::resource('owners', OwnerController::class);
            Route::get('owners-data-ajax', [OwnerController::class, 'getOwners'])->name('owners.ajax');
            Route::get('owners-data', [OwnerController::class, 'data'])->name('owners.data');
            Route::resource('users', UserController::class);
            // User Controller
            Route::get('user-ajax', [UserController::class, 'data'])->name('users.data');
            // Offer Routes
            Route::resource('offers', OfferController::class);
            Route::get('offer-ajax', [OfferController::class, 'data'])->name('offer.data');
            Route::get('offer-in-map', [\App\Http\Controllers\MapController::class, "index"])->name('Map');
            Route::get('reports/agent-report', [\App\Http\Controllers\ReportController::class, "agentOfferReport"])->name('report.agent');
            Route::get('reports/offer-status-report', [\App\Http\Controllers\ReportController::class, "offerStatusReport"])->name('report.offer_status_report');
            Route::get('reports/system-users', [\App\Http\Controllers\ReportController::class, "OfferAreaReport"])->name('report.system_usage_monthly');

            // sign Order To Client
            Route::get('offer-asing-to-client/{id}', [AssingOrderToClientController::class, 'index'])->name('asing_to_cleint');
        });

        Route::prefix('admin')->middleware('auth:admin')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            // Agent Controller
            Route::resource('agent',  AgentController::class);
            Route::get('agents-ajax', [AgentController::class, 'data'])->name('agents.data');
            Route::prefix('realstate')->name('realstate.')->group(function () {
                Route::resource('categories', RealStateCategoryController::class);
                // Real State Routes
                Route::resource('realstate', RealStateController::class);
                Route::get('realstate-data', [RealStateController::class, 'data'])->name('data');
                Route::get('realstate-data-ajax', [RealStateController::class, 'getGetRealState'])->name('ajax');
                //  Rent Routes Section Assing And OWner
                Route::post('finsh-rent', [RentController::class, 'FinshRent'])->name('FinshRent');
                Route::get('assing-realstate/{id?}', [RentController::class, 'AssignOwnerTORealState'])->name('assignOwner');
                Route::post('assing-realstate-to-owner', [RentController::class, 'Asgin'])->name('assignOwnerToRalstate');
                Route::get('rent-history', [RentController::class, 'renthistory'])->name('rent.hitory');
                Route::get('rent-history-data', [RentController::class, 'renthistoryData'])->name('rent.hitory.data');
                //  Rent Routes Section Route The Revenue
                Route::get('receipt-revenue/{id?}', [RentController::class,  'receiptRevenue'])->name('receipt');
                Route::post('receipt-revenue', [RentController::class,  'handelRevenue'])->name('Revenue');
                Route::get('revenue-hsitory', [RentController::class, 'revenueHsitory'])->name('recept_revenues.hitory');
                Route::get('revenue-hsitory-data', [RentController::class, 'revenueHsitoryData'])->name('recept_revenues.data');

                // Sale Routes And  Controller
                Route::post('recept-installment', [SaleController::class, 'receptInstallment'])->name('receptInstallment');
                Route::get('assing-sale-owner/{id?}', [SaleController::class, 'assignSaleOwner'])->name('assignSaleOwner');
                Route::get('sale-history', [SaleController::class, 'saleHistory'])->name('saleHistory');
                Route::get('sale-history-data', [SaleController::class, 'saleHistoryData'])->name('saleHistory.data');
                Route::get('recept-realstate-installment', [SaleController::class, 'receptRealStateInstallment'])->name('receptRealStateInstallment');
                Route::get('get-installment/', [SaleController::class, 'getRealStateInstallments'])->name('get_installment');
                Route::get('get-installment-history/', [SaleController::class, 'InstallmentsHistory'])->name('installment_hsitory');
                Route::get('get-installment-history-data/', [SaleController::class, 'InstallmentsHistoryData'])->name('installment_hsitory.data');

                // Rent Invoice
                Route::get('rent-invoice/{id}', [RentController::class, 'RentInvoice'])->name('rent_invoice');
                Route::get('sale-invoice/{id}', [SaleController::class, 'SaleInvoice'])->name('sale_invoice');
            });
            Route::get('finanical-treasury', [FinanicalTreasuryController::class, 'finanical'])->name('admin.finanical');
            Route::get('finanical-treasury-ajax', [FinanicalTreasuryController::class, 'data'])->name('admin.finanical.data');
            Route::post('finanical-treasury', [FinanicalTreasuryController::class, 'store'])->name('admin.finanical.store');
            Route::put('finanical-treasury-update/{id}', [FinanicalTreasuryController::class, 'update'])->name('admin.finanical.update');
            Route::get('finanical-treasury-spending', [FinanicalTreasuryController::class, 'spending'])->name('admin.spending');
            Route::get('finanical-treasury-revenues', [FinanicalTreasuryController::class, 'revenues'])->name('admin.revenues');
        });

        //  finanical-treasury Routes

        Route::get('show_attachments/{attachment}', [AttachmentsController::class, 'show'])->name('show_attachments');
        Route::get('download_attachments/{attachment}', [AttachmentsController::class, 'download'])->name('download_attachments');
        Route::post('attachments', [AttachmentsController::class, 'store'])->name('attachments.store');
    }
);