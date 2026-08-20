<?php
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
