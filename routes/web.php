<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Models\Company;

// Auth Routes
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [
    HomeController::class,
    'index',
])->name('home')->middleware(['auth','role:super_admin|company_user']);

Route::get('/companyuser', function(){
    $user=auth()->user();
    $company=Company::where('id',$user->company_id)->first();

    return view('company.companyDetail',compact('company'));
})->name('company_user')->middleware(['auth','role:company_user']);

// Company Routes
Route::prefix('company')->middleware(['auth','role:super_admin'])->group(function () {
    Route::get('/', function () {
        return view('company.create');
    })->name('company.index');
    Route::post('/create', [CompanyController::class, 'create'])
        ->name('company.create');
    Route::get('/read', [CompanyController::class, 'read'])
        ->name('company.read');
    Route::delete('/destroy', [CompanyController::class, 'delete'])
        ->name('company.delete');
    Route::get('/edit/{id}', [CompanyController::class, 'edit'])
        ->name('company.edit');
    Route::post('/update/{id}', [CompanyController::class, 'update'])
        ->name('company.update');
});

// Employee Routes
Route::prefix('employee')->middleware(['auth','role:super_admin|company_user'])->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
    Route::post('/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::get('/read', [EmployeeController::class, 'read'])->name('employee.read');
    Route::delete('/delete', [EmployeeController::class, 'delete'])->name('employee.delete');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
});
// Analytics Route
Route::get('/analytics', [AnalyticsController::class, 'gender'])->middleware(['auth','role:super_admin'])->name('analytics');
