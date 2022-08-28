<?php

use App\Http\Controllers\CrudController;
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

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [CrudController::class, 'index']);
Route::post('/manage', [CrudController::class, 'manage']);
Route::get('/edit/{id}', [CrudController::class, 'edit']);
Route::get('/delete/{id}', [CrudController::class, 'delete']);
