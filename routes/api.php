<?php

use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\StateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Users
Route::resource('users', UserController::class);

// Country
Route::resource('countries', CountryController::class);

// City
Route::resource('cities', CityController::class);

// State
Route::resource('states', StateController::class);

// Department
Route::resource('departments', DepartmentController::class);

// Employee
Route::resource('employees', EmployeeController::class);