<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;

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
//     return view('welcome');
// });

Route::get('/pos', [POSController::class, 'index']);
Route::post('/add-to-order', [POSController::class, 'addToOrder']);
Route::post('/save-order', [POSController::class, 'saveOrder']);
Route::post('/save-orderan', [OrderController::class, 'saveOrder']);
Route::post('/print-order', [POSController::class, 'printOrder']);
Route::post('/charge-order', [POSController::class, 'chargeOrder']);

