<?php

use App\Http\Controllers\TouristAttractionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect(route('login'));
});

Auth::routes();

Route::middleware('auth:web')->group(function(){
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // List tour(Raisul)
    Route::get('/list', [App\Http\Controllers\listController::class, 'index'])->name('list');
    Route::post('/taupdate', [App\Http\Controllers\listController::class, 'taupdate'])->name('taupdate');
    Route::post('/taupdateproses', [App\Http\Controllers\listController::class, 'taupdateproses'])->name('taupdateproses');

    // Story (Hendy)
    Route::get('/story', [App\Http\Controllers\StoryController::class, 'index'])->name('story');
    Route::post('/detailstory', [App\Http\Controllers\StoryController::class, 'detail'])->name('detailstory');
    Route::post('/deletestory', [App\Http\Controllers\StoryController::class, 'delete'])->name('delete');


    //TOURIST ATTRACTION
    Route::get('/tourist/attraction', [TouristAttractionController::class, 'index'])->name('touristatraction');
    Route::get('/tourist/attraction/add', [TouristAttractionController::class, 'add'])->name('touristAttractionAdd');
    Route::post('tourist/attraction/created', [TouristAttractionController::class, 'create'])->name('touristAttractionCreate');
  
    // Users Management (Dicky)
    Route::get("/users-management/admin",[App\Http\Controllers\Users\AdminController::class, 'index'])->name('users-management');
    Route::get("/users-management/admin/list",[App\Http\Controllers\Users\AdminController::class, 'getList'])->name('users-management.list');
    Route::get("/users-management/admin/detail",[App\Http\Controllers\Users\AdminController::class, 'getDetail'])->name('users-management.detail');
    Route::get("/users-management/users",[App\Http\Controllers\Users\UsersController::class, 'index'])->name('users-management.users');
    Route::get("/users-management/users/list",[App\Http\Controllers\Users\UsersController::class, 'getList'])->name('users-management.users.list');
    Route::get("/users-management/users/detail",[App\Http\Controllers\Users\UsersController::class, 'getDetail'])->name('users-management.users.detail');
});