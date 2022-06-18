<?php

use App\Http\Controllers\Api\TouristAttraction\TouristAttractionController;
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
Route::post('register',[App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
Route::post('register/admin',[App\Http\Controllers\Api\Auth\RegisterController::class, 'RegisterAdmin']);


// Route::middleware('auth:api')->group(function(){
    //CRUD API
    Route::post('create/story',[App\Http\Controllers\Api\StoryController::class, 'create']);
    Route::get('read/story',[App\Http\Controllers\Api\StoryController::class, 'readStories']);
    Route::patch('edit/story/{id}',[App\Http\Controllers\Api\StoryController::class, 'edit']);
    Route::post('update/story/{id}',[App\Http\Controllers\Api\StoryController::class, 'update']);
    Route::delete('delete/story/{id}',[App\Http\Controllers\Api\StoryController::class, 'deletestory']);


    //CRUD visit list
    Route::post('create/visit',[App\Http\Controllers\listController::class, 'create']);
    Route::get('read/visit',[App\Http\Controllers\listController::class, 'read']);
    Route::patch('edit/visit/{id}',[App\Http\Controllers\listController::class, 'edit']);
    Route::post('update/visit/{id}',[App\Http\Controllers\listController::class, 'update']);
    Route::delete('delete/visit/{id}',[App\Http\Controllers\listController::class, 'delete']);

    //Tourist Attraction Endpoint
    Route::get('tourist/attraction/list', [TouristAttractionController::class, 'touristAttractionList']);

// });