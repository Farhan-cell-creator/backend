<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [
    App\Http\Controllers\HomeController::class,
    'index'
])->name('home')->middleware('auth');




Route::prefix('company')->group(function () {
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

// Route::prefix('employee')->group(function () {
//     Route::get('/', function () {
//         return view('company.create');
//     })->name('company.index');

//     Route::post('/create', [CompanyController::class, 'create'])
//         ->name('company.create');
//     Route::get('/read', [CompanyController::class, 'read'])
//         ->name('company.read');
//           Route::delete('/destroy', [CompanyController::class, 'delete'])
//         ->name('company.delete');
//          Route::get('/edit/{id}', [CompanyController::class, 'edit'])
//     ->name('company.edit');
//      Route::post('/update/{id}', [CompanyController::class, 'update'])
//         ->name('company.update');
//         });
Route::prefix('employee')->group(function (){
     Route::get('/',[EmployeeController::class,'index'])->name('employee.index');

 Route::post('/create',[EmployeeController::class,'create'])->name('employee.create');
 Route::get('/read',[EmployeeController::class,'read'])->name('employee.read');
 Route::delete('/delete',[EmployeeController::class,'delete'])->name('employee.delete');
Route::get('/edit/{id}',[EmployeeController::class,'edit'])->name('employee.edit');
Route::post('/update/{id}',[EmployeeController::class,'update'])->name('employee.update');
});

