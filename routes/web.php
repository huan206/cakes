<?php

use App\Http\Controllers\Output;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
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

// Ex homework1
Route::get('/add-room', [RoomController::class, 'addRoom']);
Route::post('/add-room', [RoomController::class, 'storeRoom'])->name('room.store');
Route::resource('output', Output::class);

//Web sale

Route::get('/trangchu', [PageController::class, 'getIndex']);
Route::get('/type/{id}', [PageController::class, 'getLoaiSp']);
Route::get('/detail/{id}', [PageController::class, 'getDetail']);
Route::get('/contact', [PageController::class, 'getContact']);
Route::get('/about', [PageController::class, 'getAbout']);
Route::get('/admin', [PageController::class, 'getIndexAdmin']);
Route::get('getadminadd', [PageController::class, 'getAdminAdd']);
Route::post('adminadd', [PageController::class, 'postAdminAdd']);
Route::get('getadminedit/{id}', [PageController::class, 'getAdminEdit']);
Route::post('adminedit', [PageController::class, 'postAdminEdit']);
Route::post('admindelete/{id}', [PageController::class, 'postAdminDelete']);
Route::get('themgiohang/{id}', [PageController::class, 'getAddtoCart']);
Route::get('xoagiohang/{id}', [PageController::class, 'getDelItemCart']);
Route::get('order', [PageController::class, 'getCheckout']);
Route::post('order', [PageController::class, 'postCheckout']);
