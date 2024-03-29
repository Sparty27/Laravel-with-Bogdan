<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/categories')->controller(CategoryController::class)->name('categories.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{category}', 'show')->name('show');
    Route::post('/', 'store')->name('store');
    Route::get('/{category}/edit', 'edit')->name('edit');
    Route::post('/{category}', 'update')->name('update');
    Route::delete('/{category}', 'destroy')->name('destroy');
});

//Route::prefix('/products')->controller(ProductController::class)->name('products.')->group(function(){
//    Route::get('/','index')->name('index');
//    Route::get('/create','create')->name('create');
//    Route::get('/{product}', 'show')->name('show');
//    Route::post('/','store')->name('store');
//    Route::get('/{product}/edit','edit')->name('edit');
//    Route::post('/{product}', 'update')->name('update');
//    Route::delete('/{product}','destroy')->name('destroy');
//});

Route::get('/', function () {
    return view('admin.index');
});

Route::resource('products', ProductController::class);
Route::resource('tags', TagController::class);

Route::get('/test', [TestController::class, 'index'])->name('test.index');