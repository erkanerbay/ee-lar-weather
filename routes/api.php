<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('weather')->group(function () {
    Route::get('/latest', [WeatherController::class, 'latest']);
    Route::get('/states', [WeatherController::class, 'states']);
    Route::get('/status', [WeatherController::class, 'status']);
});
