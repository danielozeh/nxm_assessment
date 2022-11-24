<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     //return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);

Route::group([
    'prefix' => 'orders'
],  function($router) {
    Route::get('/', [OrderController::class, 'getOrders']);
    Route::get('/{id}', [OrderController::class, 'viewOrder']);
});

Route::group([
    'prefix' => 'reports'
],  function($router) {
    Route::get('/commission', [OrderController::class, 'commissionReport']);
    Route::post('/commission', [OrderController::class, 'recentCommissionReports']);
    Route::get('/rank', [OrderController::class, 'rankReport']);
    Route::post('/rank', [OrderController::class, 'getrankReports']);
});