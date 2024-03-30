<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WeatherController::class, 'index']);

Route::get('/weather', [WeatherController::class, 'index']);
Route::post('/weather', [WeatherController::class, 'getWeather'])->name('weather.get-weather');
Route::post('/add-city', [WeatherController::class, 'addCity']);

Route::post('/set.remove', [WeatherController::class, 'remove'])->name('remove');
