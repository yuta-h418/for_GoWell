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

//購入履歴登録
//form
Route::get('/form', 'App\Http\Controllers\PurchaseFormController@formView')->name('register_form');
//conf
Route::get('/regist/conf', 'App\Http\Controllers\PurchaseFormController@registConf')->name('register_conf');
Route::post('/regist/conf', 'App\Http\Controllers\PurchaseFormController@registConf')->name('register_conf');
//regist
Route::get('/regist/last', 'App\Http\Controllers\PurchaseFormController@regist')->name('register_last');
Route::post('/regist/last', 'App\Http\Controllers\PurchaseFormController@regist')->name('register_last');


Route::get('/purchase_history', 'App\Http\Controllers\PurchaseHistoryController@historyView')->name('history');