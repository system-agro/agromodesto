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
Route::get('/admin/client/detail/{id}', [ClientController::class, 'detail'])->name('detail');
Route::put('/admin/client/update/{id}', [ClientController::class, 'updateClient'])->name('updateClient');
Route::post('/admin/client/save', [ClientController::class, 'save'])->name('save');
Route::delete('/admin/client/delete/{id}', [ClientController::class, 'delete'])->name('delete');
Route::get('/admin/fornecedor', [FornecedorController::class, 'listFornecedor'])->name('listFornecedor');
Route::get('/admin/listClient', [ClientController::class, 'listClient'])->name('listClient');

