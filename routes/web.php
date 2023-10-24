<?php

use App\Admin\Controllers\FornecedorController;
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

Route::get('/admin/testeClient', [ClientController::class, 'testeClient'])->name('testeClient');
Route::get('/admin/detail/{id}', [ClientController::class, 'detail'])->name('detail');
Route::get('/admin/fornecedor', [FornecedorController::class, 'listFornecedor'])->name('listFornecedor');

