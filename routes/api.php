<?php

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

Route::resource('/sellers', 'SellerController')
	->only (['index', 'show', 'store', 'update', 'destroy']);

Route::resource('/orders', 'OrderController')
	->only (['index', 'show', 'store', 'update', 'destroy']);