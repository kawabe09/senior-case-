<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', [EmployeeController::class,'index']);
Route::middleware('auth')->group(function () {
    Route::get('/start', [EmployeeController::class, 'start']);
    Route::get('/end', [EmployeeController::class, 'end']);
    Route::get('/rest', [EmployeeController::class, 'rest']);
    Route::get('/rest_end', [EmployeeController::class, 'rest_end']);
    Route::get('/data', [EmployeeController::class, 'data']);
});
