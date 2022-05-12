<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\TopController@topview');

Route::get('/form', 'App\Http\Controllers\PurchaseFormController@formView')->name('register_form');

Route::get('/purchase_history', 'App\Http\Controllers\PurchaseHistoryController@historyView')->name('history');