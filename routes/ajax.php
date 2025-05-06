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
Route::get('users/representative/{representative}/participants','UserController@repParticipants')
      ->name('users.representative.participants');

Route::put('users/{user}/basic-info','UserController@updateBasicInfo')->name('users.update.basic.info');
Route::put('users/{user}/bank-info','UserController@updateBankInfo')->name('users.update.bank.info');
Route::post('users/status-toggle','UserController@statusToggle')->name('user.status.toggle');
Route::post('users/{user}/representative/update-auto-approval','UserController@updateAutoApproval')->name('user.representative.approval');
Route::post('users/{user}/upload-avatar','UserController@uploadAvatar')->name('users.upload.avatar');
Route::get('users/participant','UserController@participantIndex')->name('participants.index');
Route::apiResource('users','UserController');

Route::post('providers/remove-participants','ProviderController@removeParticipant')
      ->name('providers.remove.participants');

Route::apiResource('providers','ProviderController');
Route::get('claims/store','ClaimController@store');
Route::post('claims/admin-store','ClaimController@storeAdmin')->name('claims.store.admin');
Route::post('claims/{claim}/representative-action','ClaimController@approvedByRepresentative')->name('claims.representative.action');
Route::match(['get', 'post'],'claims/bulk-upload-file','ClaimController@bulkUploadFile')->name('claims.bulk.upload.file');
Route::match(['get', 'post'],'claims/quick-reconciliation','ClaimController@quickReconciliation')->name('claims.quick.reconciliation');
Route::get('claims/reconciled-results-file','ClaimController@reconciledResultsFile')->name('claims.reconciled.results.file');
Route::post('claims/upload-reconciled-file','ClaimController@uploadReconciledFile')->name('claims.upload.reconciled.file');
Route::get('claims/list','ClaimController@index2')->name('claims.list');
Route::post('claims/admin/approved','ClaimController@approveClaimsByAdmin')->name('claims.admin.approved');
Route::post('claims/update-claim','ClaimController@updateClaim')->name('claims.update');
Route::apiResource('claims','ClaimController');
Route::post('plans/upload','PlanController@uploadPlanFile')->name('plans.upload');
Route::get('plans/spending-data','PlanController@getSpendingData')->name('plans.spending.data');
Route::get('plans/provider-spending-data','PlanController@getProviderSpendingData')->name('plans.provider.spending.data');
Route::post('plans/provider-budget-allocation','PlanController@updateProviderBudgetAllocation')->name('budget.allocation');
Route::get('plans/provider-budget-allocation','PlanController@getProviderBudgetAllocation')->name('get.budget.allocation');
Route::apiResource('plans','PlanController');



Route::apiResource('services','ServiceController');
Route::post('admin/update-permissions','AdminController@updatePermissions')->name('admins.update.permission');
Route::apiResource('admins','AdminController');

// ajax.claims.upload.reconciled.file


