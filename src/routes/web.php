<?php

use App\Http\Controllers\ContactController;
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

Route::get('/', [ContactController::class, 'contact']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'thanks']);
Route::post('/', [ContactController::class, 'modify']);

Route::middleware('auth')->group(function () {
    Route::get('/admin', [ContactController::class, 'admin']);
});
Route::post('/login', [ContactController::class, 'login']);
Route::post('/register', [ContactController::class, 'register']);
Route::delete('/delete', [ContactController::class, 'delete']);

Route::get('/search', [ContactController::class, 'search']);
Route::get('/reset', [ContactController::class, 'admin']);

Route::get('/export', [ContactController::class, 'export']);
