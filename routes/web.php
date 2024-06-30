<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Reports\{
    ReportsController, 
    InstallmentReportController,
    PaymentReportControlle
};
use Carbon\Carbon;

// Route::get('/', function () {
//     return view('welcome');
// });


// routes/backpack/custom.php

Route::get('/admin/dashboard', [ReportsController::class, 'index'])->name('dashboard.custom');

Route::middleware(
    array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    )
)->group(function(){
    
    Route::group(['prefix' => '/admin/reports'], function(){
        Route::get('/proyection', [ReportsController::class, 'proyection'])->name('admin.reports.proyection');
        // Route::post('/filter',    [ReportsController::class, 'proyectionFilter'])->name('admin.reports.filter');    
    });
    
    
    Route::group(['prefix' => '/admin/reports/installments'], function(){
        Route::get('/', [InstallmentReportController::class, 'index'])->name('admin.reports.installments');
    });

    Route::group(['prefix' => '/admin/reports/payments'], function(){
        Route::get('/', [PaymentReportControlle::class, 'index'])->name('admin.reports.payments');
    });

});




