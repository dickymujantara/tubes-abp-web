<?php

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
    Route::get('/story', [App\Http\Controllers\StoryController::class, 'index'])->name('story');
    Route::post('/detailstory', [App\Http\Controllers\StoryController::class, 'detail'])->name('detailstory');
    Route::post('/deletestory', [App\Http\Controllers\StoryController::class, 'delete'])->name('delete');
});
