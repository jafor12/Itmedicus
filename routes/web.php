<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//===================Start company ==============
Route::get('/company', [App\Http\Controllers\CompaniesController::class, 'index'])->name('company');
Route::get('/add-company', [App\Http\Controllers\CompaniesController::class, 'addCompany'])->name('add-company');
Route::post('/new-company', [App\Http\Controllers\CompaniesController::class, 'storeCompany'])->name('new-company');
Route::get('/edit-company/{id}', [App\Http\Controllers\CompaniesController::class, 'editCompany'])->name('edit-company');
Route::post('/update-company', [App\Http\Controllers\CompaniesController::class, 'updateCompany'])->name('update-company');
Route::get('/delete-company/{id}', [App\Http\Controllers\CompaniesController::class, 'deleteCompany'])->name('delete-company');
//===================end company ==============

//===================Start Employee ==============
Route::resource('employee', \App\Http\Controllers\EmployeesController::class);
//===================end Employee ==============
