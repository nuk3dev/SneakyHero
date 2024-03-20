<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [IndexController::class, 'index']);
Route::post('/', [IndexController::class, 'InsertAjaxData']);
Route::get('/dashboard', [DashboardController::class, 'dashboard']);
Route::get('/dashboard/edit/{id}', [DashboardController::class, 'editPlayerById'])->where('id', '[0-9]+');
Route::get('/dashboard/delete/{id}', [DashboardController::class, 'deletePlayerById'])->where('id', '[0-9]+');
Route::post('createPlayer', [DashboardController::class, 'insertPlayer']);
Route::post('/dashboard/edit/{id}', [DashboardController::class, 'inserteditedplayer'])->where('id', '[0-9]+');
Route::post('/dashboard/editPlayer/{id}', [DashboardController::class, 'inserteditedplayer'])->where('id', '[0-9]+');



