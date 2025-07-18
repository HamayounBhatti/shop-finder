<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ClaimSettlementController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QAController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'profile', 'name' => 'profile.', 'as' => 'profile.'], function () {
    Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    Route::get('/password/{id}', [ProfileController::class, 'password'])->name('password.edit');
    Route::put('/update/password/', [ProfileController::class, 'updatePassword'])->name('password.update');
});
});
Route::middleware(['auth','has_permission:users'])->group(function () {
    /* Route User */
    Route::group(['prefix' => 'user', 'name' => 'user.', 'as' => 'user.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/update', [UserController::class, 'update'])->name('update');
        
    });
});
Route::middleware(['auth','has_permission:roles-permissions-shops'])->group(function () {
    // Route shop Page
    Route::group(['prefix' => 'shop', 'name' => 'shop.', 'as' => 'shop.'], function () {
            Route::get('/', [ShopController::class, 'index'])->name('index');
            Route::get('/create', [ShopController::class, 'create'])->name('create');
            Route::post('/', [ShopController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ShopController::class, 'edit'])->name('edit');
            Route::put('/', [ShopController::class, 'update'])->name('update');
            Route::put('/updateStatus/{id}', [ShopController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/delete/{id}', [ShopController::class, 'destroy'])->name('destroy');
            Route::get('/get-shop-list', [ShopController::class, 'getshopList'])->name('getshopList');
            Route::get('/status/update/{id}', [ShopController::class, 'createSubmitRecord'])->name('createSubmitRecord');
        });
    // Route Roles Page
    Route::group(['prefix' => 'roles', 'name' => 'roles.', 'as' => 'roles.'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('destroy');
        Route::get('/users-list', [RoleController::class, 'getUsersList'])->name('getUsersList');
    });

    // Route Permissions Page
    Route::group(['prefix' => 'permission', 'name' => 'permission.', 'as' => 'permission.'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RoleController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('destroy');
        Route::get('/users-list', [RoleController::class, 'getUsersList'])->name('getUsersList');
    });


});
     // Route Claim Page
	Route::middleware(['auth','has_permission:claim'])->group(function () {
        Route::group(['prefix' => 'claim', 'name' => 'claim.', 'as' => 'claim.'], function () {
            Route::get('/', [ClaimController::class, 'index'])->name('index');
            Route::get('/claim-settlement-form/{id}', [ClaimSettlementController::class, 'index'])->name('claim.settlement.form');
            Route::get('/closed', [ClaimController::class, 'closedClaim'])->name('closed.claim');
            Route::get('/create', [ClaimController::class, 'create'])->name('create');
            Route::post('/', [ClaimController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ClaimController::class, 'edit'])->name('edit');
            Route::put('/update', [ClaimController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ClaimController::class, 'destroy'])->name('destroy');
            Route::get('/get-claim-list', [ClaimController::class, 'getclaimList'])->name('getclaimList');
            Route::get('/get-closed-claim-list', [ClaimController::class, 'getclosedclaimList'])->name('getclosedclaimList');
            Route::put('/submit-record', [ClaimController::class, 'submitRecord'])->name('submitRecord');
            Route::get('/status/update/{id}', [ClaimController::class, 'createSubmitRecord'])->name('createSubmitRecord');
            Route::put('/closed-record', [ClaimController::class, 'locallyClosedClaim'])->name('locallyClosedClaim');
            Route::get('/locally/closed/{id}', [ClaimController::class, 'locallyClosed'])->name('locallyClosed');
            Route::get('/get-claim-by-id/{id}', [ClaimController::class, 'getClaimById'])->name('get-claim-by-id');

            
        });
	/* Route User */

    });
    // Route QA Page
	Route::middleware(['auth','has_permission:QA'])->group(function () {	
        Route::group(['prefix' => 'qa', 'name' => 'qa.', 'as' => 'qa.'], function () {
            Route::get('/claims', [QAController::class, 'index'])->name('claims');
            Route::delete('/delete/{id}', [QAController::class, 'destroy'])->name('destroy');
            Route::get('/get-qa-claim-list', [QAController::class, 'getclaimList'])->name('getQaClaimList');
            Route::put('/submit-record', [QAController::class, 'submitRecord'])->name('qaSubmitRecord');
            Route::put('/received-claim', [QAController::class, 'receivedClaim'])->name('qaReceivedClaim');
            Route::get('/gallary/{id}', [QAController::class, 'gallary'])->name('gallary');
            Route::get('/received/product/{id}', [QAController::class, 'createReceivedClaim'])->name('createReceivedClaim');
            Route::get('/status/update/{id}', [QAController::class, 'createSubmitRecord'])->name('createSubmitRecord');
            Route::get('/claim-settlement-form/{id}', [ClaimSettlementController::class, 'index'])->name('claim.settlement.form');
            Route::get('/get-claim-by-id/{id}', [ClaimController::class, 'getClaimById'])->name('get-claim-by-id');

        });
	/* Route User */

    });
    // Route Distribution Page  
	Route::middleware(['auth','has_permission:Distribution'])->group(function () {	
        Route::group(['prefix' => 'distribution', 'name' => 'distribution.', 'as' => 'distribution.'], function () {
            Route::get('/claims', [DistributionController::class, 'index'])->name('claims');
            Route::get('/repairs', [DistributionController::class, 'repair'])->name('repairs');
            Route::delete('/delete/{id}', [DistributionController::class, 'destroy'])->name('destroy');
            Route::get('/get-distribution-claim-list', [DistributionController::class, 'getclaimList'])->name('getDistributionClaimList');
            Route::get('/get-distribution-repair-list', [DistributionController::class, 'getRepairList'])->name('getDistributionRepairList');
            Route::put('/submit-record', [DistributionController::class, 'submitRecord'])->name('distributionSubmitRecord');
            Route::get('/status/update/{id}', [DistributionController::class, 'createSubmitRecord'])->name('createSubmitRecord');
            Route::get('/claim-settlement-form/{id}', [ClaimSettlementController::class, 'index'])->name('claim.settlement.form');
            Route::get('/get-claim-by-id/{id}', [ClaimController::class, 'getClaimById'])->name('get-claim-by-id');
        /* Route User */
        });  
    });
    // Route Reports Pages
    Route::middleware(['auth','has_permission:reports'])->group(function () {	
        Route::group(['prefix' => 'report', 'name' => 'report.', 'as' => 'report.'], function () {
            // Monthly Reports
            Route::get('/monthly-report-form', [ReportController::class, 'monthlyReport'])->name('monthly');
            Route::post('/monthly-report', [ReportController::class, 'generateMonthlyReport'])->name('monthly-report.generate');
            Route::get('/monthly-report/export', [ReportController::class, 'exportMonthlyReport'])->name('monthly.export');
            Route::get('/monthly-report/{month}', [ReportController::class, 'generateMonthlyReport'])->name('monthly-report.get');
            // Custom Date Range Reports
            Route::get('/custom', [ReportController::class, 'customReportForm'])->name('custom-report.form');
            Route::post('/custom/generate', [ReportController::class, 'generateCustomReport'])->name('custom-report.generate');
            Route::post('/custom/export', [ReportController::class, 'exportCustomReport'])->name('custom-report.export');
            // Route::get('/yearly-report', [ReportController::class, 'yearlyReport'])->name('report.yearly');
            // Route::get('/yearly-report/export', [ReportController::class, 'exportYearlyReport'])->name('report.yearly.export');
        });
    });
Route::get('/clear-cache', function () {
    Cache::flush();
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('event:clear');
    Artisan::call('optimize');
    return "All Cache was cleared";
});

require __DIR__.'/auth.php';
