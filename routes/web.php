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

Route::post('/create', [CompanyController::class, 'create']);
Route::post('/read', [CompanyController::class, 'read']);