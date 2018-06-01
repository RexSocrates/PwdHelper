<?php

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

// 取得密碼加密輸入頁面以及加密列表
Route::get('getEncryptionsList', 'EncryptionController@getEncryptionsList');

// 送出加密表單
Route::post('encrypt', 'EncryptionController@encrypt');

// 取得解密頁面
Route::get('getDecryptionPage', 'EncryptionController@getDecryptionPage');

// 送出表單並進行解密
Route::post('decrypt', 'EncryptionController@decrypt');

// 以下為測試路由

Route::get('downloadFile', 'EncryptionController@downloadFile');

Route::get('/encryption', 'EncryptionController@ceasar');

Route::get('/generatePwd', 'EncryptionController@generatePwd');

Route::get('/readFile', 'EncryptionController@readFile');

Route::get('/fileUpload', function() {
    return view('fileUpload');
});
Route::post('/fileUpload', 'EncryptionController@fileUpload');

Route ::get('desencryption','DesEncryptionController@doDes');