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

//Route::get('/', function () {
//    return view('welcome');
//});

// 載入功能列鰾
Route::get('/', 'EncryptionController@getFunctionsList');

// 取得密碼加密輸入頁面以及加密列表
Route::get('getEncryptionsList', 'EncryptionController@getEncryptionsList');
// 送出加密表單
Route::post('encrypt', 'EncryptionController@encrypt');

// 取得解密頁面
Route::get('getDecryptionPage', 'EncryptionController@getDecryptionPage');
// 送出表單並進行解密
Route::post('decrypt', 'EncryptionController@decrypt');

// 取得隨機生成密碼的頁面
Route::get('randomPwd', 'EncryptionController@getRandomPwdPage');
// 送出表單，產生隨機密碼，接著進行加密
Route::post('randomPwd', 'EncryptionController@getRandomPwd');

// 更換加密方式
Route::get('changeEncryptionMethod', 'EncryptionController@getEncryptionChangePage');
// 送出表單更換加密方式
Route::post('changeEncryptionMethod', 'EncryptionController@changeEncryptionMethod');

// 送出表單變更密碼
Route::post('changePwd', 'EncryptionController@changePwd');

// 以下為測試路由

Route::get('testURL', 'EncryptionController@test');

Route::get('downloadFile', 'EncryptionController@downloadFile');

Route::get('/encryption', 'EncryptionController@ceasar');

Route::get('/generatePwd', 'EncryptionController@generatePwd');

Route::get('/readFile', 'EncryptionController@readFile');

Route::get('/fileUpload', function() {
    return view('fileUpload');
});
Route::post('/fileUpload', 'EncryptionController@fileUpload');
//des加密測試網址
Route ::get('desencryption','DesEncryptionController@doDes');
//測試datatable
Route ::get('passwordlist',function (){
   return view('passwordlist');
});