<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/member', function (Request $request) {
    return $request->member();
});
Route::post('login', 'LoginController@login');
Route::post('register', 'MemberController@store');

Route::middleware('auth:api')->post('transfer','TransferController@transfer');
Route::middleware('auth:api')->post('deposit','TransferController@deposit');
Route::middleware('auth:api')->post('withdraw','TransferController@withdraw');
Route::middleware('auth:api')->get('member', 'MemberController@index');
Route::middleware('auth:api')->get('logout', 'LogoutController@logout');
