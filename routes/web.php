<?php

use App\Http\Controllers\Backend\ChangePasswordController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\HomeController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('countries', CountryController::class);
Route::resource('users', UserController::class);
Route::resource('cities', CityController::class);
Route::resource('states', StateController::class);
Route::resource('departments', DepartmentController::class);

Route::post('users/{user}/change-password', [ChangePasswordController::class, 'change_password'])->name('users.change.password');

/** this is default from tutorial */
// Route::get('{any}', function() { 
//     return view('employees.index'); 
// })->where('any', '.*');

Route::get('/employees', function() {
    return view('employees.index');
})->middleware('auth.basic');

Route::any('{query}', function() { 
    return redirect('home'); 
})->where('query', '.*');