<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/system', function () {
//     return Inertia::render('System/index');
// })->middleware(['auth', 'verified'])->name('system');

Route::get('/system/country', function () {
    return Inertia::render('System/Country/index');
})->middleware(['auth', 'verified'])->name('system/country');

Route::get('/system/state', function () {
    return Inertia::render('System/State/index');
})->middleware(['auth', 'verified'])->name('system/state');

Route::get('/system/city', function () {
    return Inertia::render('System/City/index');
})->middleware(['auth', 'verified'])->name('system/city');

Route::get('/system/department', function () {
    return Inertia::render('System/Department/index');
})->middleware(['auth', 'verified'])->name('system/department');

Route::get('/user', function () {
    return Inertia::render('User/index');
})->middleware(['auth', 'verified'])->name('user');

Route::get('/employee', function () {
    return Inertia::render('Employee/index');
})->middleware(['auth', 'verified'])->name('employee');

require __DIR__.'/auth.php';
