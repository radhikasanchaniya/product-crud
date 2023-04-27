<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['is_admin']], function () {    
        // Company Route's
        Route::resource('item', ItemController::class);
        Route::post('item-datalist', [ItemController::class, 'dataList'])->name('item.datalist');
    });
        


    // Employee Route's
    Route::resource('product', ProductController::class);
    Route::post('product-datalist', [ProductController::class, 'dataList'])->name('product.datalist');
});
