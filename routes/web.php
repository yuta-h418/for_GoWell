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

//購入履歴一覧
Route::get('/purchase_history', 'App\Http\Controllers\PurchaseHistoryController@historyView')->name('history');
//編集
Route::post('/purchase_history/edit', 'App\Http\Controllers\PurchaseHistoryController@historyEdit')->name('history_edit');
//削除
Route::post('/purchase_history/delete', 'App\Http\Controllers\PurchaseHistoryController@historyDelete')->name('history_delete');

// 購入履歴CSVアップロード
Route::get('/upload/form', 'App\Http\Controllers\PurchaseHistory_uploadController@uploadformView')->name('upload_form');
// 確認
Route::get('/upload/conf', 'App\Http\Controllers\PurchaseHistory_uploadController@uploadConf')->name('upload_conf');
Route::post('/upload/conf', 'App\Http\Controllers\PurchaseHistory_uploadController@uploadConf')->name('upload_conf');
Route::get('/upload/conf', 'App\Http\Controllers\PurchaseHistory_uploadController@uploadConf')->name('upload_conf');
//登録
Route::post('/upload/last', 'App\Http\Controllers\PurchaseHistory_uploadController@uploadRegist')->name('upload_uploadRegist');

//検索
Route::get('/search/form', 'App\Http\Controllers\SearchFormController@searchForm')->name('search_form');

//検索結果
// Route::get('/upload/conf', 'App\Http\Controllers\PurchaseHistory_uploadController@uploadConf')->name('upload_conf');
Route::get('/search/result', 'App\Http\Controllers\SearchFormController@searchResult')->name('search_result');
Route::post('/search/result', 'App\Http\Controllers\SearchFormController@searchResult')->name('search_result');

//CSV出力
Route::post('/search/download', 'App\Http\Controllers\CSV_DownloadController@csvExoprt')->name('search_DL');