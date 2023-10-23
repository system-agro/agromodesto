<?php

use App\Admin\Controllers\CaminhaoController;
use App\Admin\Controllers\ClientController;
use App\Admin\Controllers\FornecedorController;
use App\Admin\Controllers\GadoController;
use App\Admin\Controllers\MadeirasController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    // $router->resource('clients', ClientController::class);
    $router->resource('madeiras', MadeirasController::class);
    $router->resource('caminhaos', CaminhaoController::class);
    $router->resource('gados', GadoController::class);
    $router->get('clients', 'ClientController@listClient')->name('listClient');
    $router->get('fornecedor', 'FornecedorController@listFornecedor')->name('listFornecedor');

});
