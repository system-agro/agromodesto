<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Controllers\Dashboard;
use OpenAdmin\Admin\Layout\Column;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Layout\Row;
use App\Admin\Controllers\NatalidadeController;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->css_file(Admin::asset("open-admin/css/pages/dashboard.css"))
            ->title('Inicio')
            ->description('gestão geral')
            // ->row(Dashboard::title())
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $natalidadeController = new NatalidadeController();
                    $column->append($natalidadeController->listFilterNatalidade());
                });

                
                $row->column(4, function (Column $column) {
                    $gadoController = new GadoController();
                    $column->append($gadoController->lucroMensalGado());
                });
                
                $row->column(4, function (Column $column) {
                    $madeiraController = new MadeirasController();
                    $column->append($madeiraController->lucroMensalMadeira());
                });
                
                $row->column(4, function (Column $column) {
                    $caminhaoController = new CaminhaoController();
                    $column->append($caminhaoController->lucroMensalCaminhao());
                });

                
            });
    }
}
