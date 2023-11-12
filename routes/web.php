<?php

use App\Admin\Controllers\CaminhaoController;
use App\Admin\Controllers\FornecedorController;
use App\Admin\Controllers\GadoController;
use App\Admin\Controllers\MadeirasController;
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
Route::get('/admin/listClient', [ClientController::class, 'listClient'])->name('listClient');

Route::get('/admin/fornecedor', [FornecedorController::class, 'listFornecedor'])->name('listFornecedor');
Route::post('/admin/fornecedor/save', [FornecedorController::class,  'save'])->name('save');
Route::get('/admin/fornecedor/detail/{id}', [FornecedorController::class , 'detail'])->name('detail');
Route::delete('/admin/fornecedor/delete/{id}', [FornecedorController::class, 'delete'])->name('delete');
Route::put('/admin/fornecedor/update/{id}', [FornecedorController::class, 'updateFornecedor'])->name('updateFornecedor');


Route::post('/admin/gado/save', [GadoController::class, 'save'])->name('save');
Route::put('/admin/gado/update/{id}', [GadoController::class, 'updateReport'])->name('updateReport');
Route::get('/admin/gado/detail/{id}', [GadoController::class, 'detail'])->name('detail');
Route::delete('/admin/gado/delete/{id}', [GadoController::class, 'delete'])->name('delete');

Route::post('/admin/madeira/save', [MadeirasController::class, 'save'])->name('save');
Route::put('/admin/madeira/update/{id}', [MadeirasController::class, 'updateReport'])->name('updateReport');
Route::get('/admin/madeira/detail/{id}', [MadeirasController::class, 'detail'])->name('detail');
Route::delete('/admin/madeira/delete/{id}', [MadeirasController::class, 'delete'])->name('delete');
Route::get('/admin/listMadeira', [MadeirasController::class, 'listMadeira'])->name('listMadeira');

Route::post('/admin/caminhaos/save', [CaminhaoController::class, 'save'])->name('save');
Route::put('/admin/caminhaos/update/{id}', [CaminhaoController::class, 'updateReport'])->name('updateReport');
Route::get('/admin/caminhaos/detail/{id}', [CaminhaoController::class, 'detail'])->name('detail');
Route::delete('/admin/caminhaos/delete/{id}', [CaminhaoController::class, 'delete'])->name('delete');
Route::get('/admin/listCaminhoes', [CaminhaoController::class, 'listCaminhoes'])->name('listCaminhoes');

Route::get('/admin/download/{id}', [MadeirasController::class, 'generatePDF'])->name('generatePDF');

