<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\PositionController;
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

Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('employees/edit/{id}/', [EmployeeController::class, 'edit']);
Route::post('employees/update', [EmployeeController::class, 'update'])->name('employees.update');
Route::get('employees/destroy/{id}/', [EmployeeController::class, 'destroy']);
Route::get('employees/show/{id}/', [EmployeeController::class, 'show'])->name('employees.show');

Route::resource('positions', PositionController::class);


Route::middleware(['role:admin'])->prefix('admin_panel')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('homeAdmin');
});
