<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;

// Auth Routes
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [
    HomeController::class,
    'index',
])->name('home')->middleware(['auth', 'role:super_admin|company_user|employee']);

Route::get('/companyuser',[CompanyController::class,'companydetail'])->name('company_user')
  ->middleware(['auth', 'role:company_user|employee']);

// Company Routes
Route::prefix('company')->middleware(['auth', 'role:super_admin'])->group(function () {
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
Route::prefix('employee')->middleware(['auth', 'role:super_admin|company_user'])->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
    Route::post('/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::get('/read', [EmployeeController::class, 'read'])->name('employee.read');
    Route::delete('/delete', [EmployeeController::class, 'delete'])->name('employee.delete');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
});
// Analytics Route
Route::get('/analytics', [AnalyticsController::class, 'gender'])->middleware(['auth', 'role:super_admin'])->name('analytics');

Route::prefix('task')->middleware('auth')->group(function () {

    // Create Task
    Route::get('/', [TaskController::class, 'index'])->middleware('permission:task-create')->name('task.index');

    Route::post('/create', [TaskController::class, 'createTask'])->middleware('permission:task-create')->name('task.create');

    // Read Task
    Route::get('/read', [TaskController::class, 'readTask'])->middleware('permission:task-read')->name('task.read');

    // Update Task
    Route::get('/edit/{id}', [TaskController::class, 'editTask'])->middleware('permission:task-update')->name('task.edit');

    Route::put('/update/{id}', [TaskController::class, 'updateTask'])->middleware('permission:task-update')->name('task.update');

    // Delete Task
    Route::delete('/delete', [TaskController::class, 'deleteTask'])->middleware('permission:task-delete')->name('task.delete');

});
