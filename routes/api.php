<?php
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\PdfController;

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
Route::prefix('employee')->group(function () {
    Route::get('/all', [EmployeeController::class, 'getAllEmployee']);
    Route::get('/id', [EmployeeController::class, 'getEmployeeById']);
    Route::delete('/delete', [EmployeeController::class, 'deleteEmployeeById']);
});


Route::get('/country',[CountryController::class,'getCountry']);
Route::get('/visitor-details', [VisitorController::class, 'details']);
Route::get('/pdf', [PdfController::class, 'generate']);
