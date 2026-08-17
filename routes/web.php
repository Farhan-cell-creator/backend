<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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
        



});
