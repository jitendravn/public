<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestController;
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

Route::resource('blog', BlogController::class);
// Route::resource('test', TestController::class);
Route::get('test/index', [TestController::class, 'index'])->name("test.index");
// Route::get('status/{id}',[BlogController::class,'status']);
