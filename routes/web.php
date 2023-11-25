<?php

use App\Http\Controllers\DueController;
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

Route::get('/', [DueController::class, 'index']);
Route::get('/create-due', [DueController::class, 'create']);
Route::get('/edit-due/{id}', [DueController::class, 'edit']);

Route::post('/save-due', [DueController::class, 'store']);
Route::post('/update-due/{id}', [DueController::class, 'update']);