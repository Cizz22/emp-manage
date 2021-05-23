<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//protected route
Route::group( ['middleware' => ['auth:sanctum']] ,function () {
    Route::resource('departement', DepartementController::class);
    Route::resource('employee', EmployeeController::class);
    Route::post('/employee/payment', [EmployeeController::class , 'payment']);
    Route::delete('employee/payment/delete/{id}', [EmployeeController::class, 'destroyPayment']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'user']);
});
