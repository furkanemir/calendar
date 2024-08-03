<?php

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

Route::get('/', [\App\Http\Controllers\EventController::class, 'index']);
Route::post('/events', [\App\Http\Controllers\EventController::class, 'store']);
Route::delete('/events/{id}', [\App\Http\Controllers\EventController::class, 'delete']);
Route::put('/events/{id}', [\App\Http\Controllers\EventController::class,'update']);
Route::get('/events', [\App\Http\Controllers\EventController::class, 'getEventsByUser']);

Route::get('/download-pdf', [\App\Http\Controllers\PDFController::class, 'downloadPDF']);

