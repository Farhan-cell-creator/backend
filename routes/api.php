<?php
use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\EagerController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\ArrayController;

use Jenssegers\Agent\Facades\Agent;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Task 6 Api Endpoint
// User Api EndPoint
Route::prefix('user')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

});
// Employee Api EndPoint
Route::prefix('employee')->middleware('key')->group(function () {
    Route::get('/all', [EmployeesController::class, 'getAllEmployee']);
    Route::get('/id', [EmployeesController::class, 'getEmployeeById']);
    Route::delete('/delete', [EmployeesController::class, 'deleteEmployeeById']);
});


Route::get('/country',[CountryController::class,'getCountry']);
Route::get('/visitor-details', [VisitorController::class, 'details']);
Route::get('/pdf', [PdfController::class, 'generate']);
Route::get('/company', [EagerController::class, 'show']);

// route for VerifyApiKey middleware
Route::get('/key',[KeyController::class,'authenticate'])->middleware('key');
Route::get('/array',[ArrayController::class,'arrayPractice']);
