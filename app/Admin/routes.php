<?php

use App\Admin\Controllers\ClientController;
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
    $router->resource('clients', ClientController::class);
    $router->resource('madeiras', MadeirasController::class);
    $router->get('/loadClientDat/{database}', 'ClientController@loadClientData')->name('loadClientData');
    // Route::get('/load-client-data', [ClientController::class, 'loadClientData'])->name('loadClientData');



});
