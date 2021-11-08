<?php

use App\Http\Controllers\BlogController;
use App\Models\Blog;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog',[BlogController::class,'index']);
Route::post('/add_blog',[BlogController::class,'store']);
Route::get('edit/{id}',[BlogController::class,'edit']);
Route::post('update/{id}',[BlogController::class,'update']);
Route::delete('delete',[BlogController::class,'delete'])->name('deleteBlog');
Route::get('status/{id}',[BlogController::class,'status']);