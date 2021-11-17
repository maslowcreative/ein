<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('users/store','UserController@store');
Route::apiResource('users','UserController');

Route::post('providers/remove-participants','ProviderController@removeParticipant')
      ->name('providers.remove.participants');

Route::apiResource('providers','ProviderController');
Route::get('claims/store','ClaimController@store');
Route::post('claims/{claim}/representative-action','ClaimController@approvedByRepresentative')->name('claims.representative.action');
Route::match(['get', 'post'],'claims/bulk-upload-file','ClaimController@bulkUploadFile')->name('claims.bulk.upload.file');
Route::get('claims/list','ClaimController@index2')->name('claims.list');
Route::apiResource('claims','ClaimController');
Route::apiResource('plans','PlanController');

Route::apiResource('services','ServiceController');
Route::apiResource('admins','AdminController');




