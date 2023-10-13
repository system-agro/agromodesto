<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\ClientController;

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

Route::get('/', function () {
    return view('welcome');
    
});

Route::get('/loadClientData/{database}', [ClientController::class, 'loadClientData'])->name('loadClientData');
// Route::get('/loadClientData/{database}', 'ClientController@loadClientData')->name('loadClientData');

// Route::get('/load-client-data', 'ClientController@loadClientData')->name('loadClientData');

// Route::get('/load-client-data', [ClientController::class, 'loadClientData'])->name('loadClientData');
