<?php

namespace App\Admin\Controllers;

use \App\Models\Caminhao;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class CaminhaoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Caminhao';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Caminhao());

        $grid->column('id', __('Id'));
        $grid->column('placa', __('Placa'));
        $grid->column('data_frete', __('Data frete'));
        $grid->column('valor_combustivel', __('Valor combustivel'));
        $grid->column('km_inicial', __('Km inicial'));
        $grid->column('valor_frete', __('Valor frete'));
        $grid->column('valor_manutencao', __('Valor manutencao'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Caminhao::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('placa', __('Placa'));
        $show->field('data_frete', __('Data frete'));
        $show->field('valor_combustivel', __('Valor combustivel'));
        $show->field('km_inicial', __('Km inicial'));
        $show->field('valor_frete', __('Valor frete'));
        $show->field('valor_manutencao', __('Valor manutencao'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Caminhao());

        $form->text('placa', __('Placa'));
        $form->datetime('data_frete', __('Data frete'))->default(date('Y-m-d H:i:s'));
        $form->text('valor_combustivel', __('Valor combustivel'));
        $form->text('km_inicial', __('Km inicial'));
        $form->text('valor_frete', __('Valor frete'));
        $form->text('valor_manutencao', __('Valor manutencao'));

        return $form;
    }
}
