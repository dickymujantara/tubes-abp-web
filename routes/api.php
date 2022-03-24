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
Route::post('login',[App\Http\Controllers\Api\Auth\LoginController::class, 'login']);

Route::middleware('auth:api')->group(function(){
    Route::get('dashboard/chart',[App\Http\Controllers\Api\DashboardController::class, 'chartRfp']);
    Route::get('dashboard/card',[App\Http\Controllers\Api\DashboardController::class, 'cardRfp']);

    Route::get('inbox',[App\Http\Controllers\Api\InboxController::class, 'listInbox']);
    Route::get('inbox/{id?}',[App\Http\Controllers\Api\InboxController::class, 'getInbox']);
    Route::delete('inbox/{id}',[App\Http\Controllers\Api\InboxController::class, 'deleteInbox']);

    Route::get('user/profile',[App\Http\Controllers\Api\Auth\ProfileController::class, 'getProfile']);
    Route::post('user/profile/update',[App\Http\Controllers\Api\Auth\ProfileController::class, 'updateProfile']);
    Route::post('user/profile/update/photo',[App\Http\Controllers\Api\Auth\ProfileController::class, 'updatePhoto']);
    Route::post('user/profile/change-password',[App\Http\Controllers\Api\Auth\ProfileController::class, 'changePassword']);

    Route::get('master/projects',[App\Http\Controllers\Api\Reference\ProjectController::class, 'listProjectsPaginate']);
    Route::get('master/projects/list',[App\Http\Controllers\Api\Reference\ProjectController::class, 'listProjects']);

    Route::get('master/bank-account',[App\Http\Controllers\Api\Reference\BankAccountController::class, 'listBankPaginate']);
    Route::get('master/bank-account/list',[App\Http\Controllers\Api\Reference\BankAccountController::class, 'listBank']);

    Route::get('rfp',[App\Http\Controllers\Api\RfpController::class, 'listRfp']);
    Route::get('rfp/{id?}',[App\Http\Controllers\Api\RfpController::class, 'RfpDetail']);
    Route::get('rfp/{id?}/items',[App\Http\Controllers\Api\RfpController::class, 'RfpDetailItems']);
    Route::get('rfp/{id?}/items/list',[App\Http\Controllers\Api\RfpController::class, 'RfpDetailItemsPage']);
    Route::get('rfp/{id?}/attach',[App\Http\Controllers\Api\RfpController::class, 'RfpListAttach']);
    Route::get('rfp/item/{id?}',[App\Http\Controllers\Api\RfpController::class, 'RfpItem']);
    Route::get('rfp/{id?}/log',[App\Http\Controllers\Api\RfpController::class, 'RfpLog']);
    Route::post('rfp',[App\Http\Controllers\Api\RfpController::class, 'createRfp']);
    Route::post('rfp/{id?}/item',[App\Http\Controllers\Api\RfpController::class, 'createDetailRfp']);
    Route::post('rfp/{id?}/attach',[App\Http\Controllers\Api\RfpController::class, 'createAttachRfp']);
    Route::put('rfp/{id?}',[App\Http\Controllers\Api\RfpController::class, 'updateRfp']);
    Route::put('rfp/{id?}/total-amount',[App\Http\Controllers\Api\RfpController::class, 'updateTotalAmountRfp']);
    Route::put('rfp/item/{id?}',[App\Http\Controllers\Api\RfpController::class, 'updateDetailRfp']);
    Route::delete('rfp/item/{id?}',[App\Http\Controllers\Api\RfpController::class, 'deleteDetailRfp']);
    Route::delete('rfp/attach/{id?}',[App\Http\Controllers\Api\RfpController::class, 'deleteAttachRfp']);
});
