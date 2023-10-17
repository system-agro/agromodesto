<?php

namespace App\Admin\Controllers;

use \App\Models\Madeiras;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class MadeirasController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Madeiras';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Madeiras());

        $grid->column('id', __('Id'));
        $grid->column('tipo_madeira', __('Tipo madeira'));
        $grid->column('data_venda', __('Data venda'));
        $grid->column('valor_compra', __('Valor compra'));
        $grid->column('quantida_compra', __('Quantida compra'));
        $grid->column('valor_venda', __('Valor venda'));
        $grid->column('frete', __('Frete'));
        $grid->column('icms', __('Icms'));
        $grid->column('lucro', __('Lucro'));
        $grid->column('cliente', __('Cliente'));
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
        $show = new Show(Madeiras::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('tipo_madeira', __('Tipo madeira'));
        $show->field('data_venda', __('Data venda'));
        $show->field('valor_compra', __('Valor compra'));
        $show->field('quantida_compra', __('Quantida compra'));
        $show->field('valor_venda', __('Valor venda'));
        $show->field('frete', __('Frete'));
        $show->field('icms', __('Icms'));
        $show->field('lucro', __('Lucro'));
        $show->field('cliente', __('Cliente'));
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
        $form = new Form(new Madeiras());

        $form->text('tipo_madeira', __('Tipo madeira'));
        $form->date('data_venda', __('Data venda'))->default(date('Y-m-d'));
        $form->text('valor_compra', __('Valor compra'));
        $form->text('quantida_compra', __('Quantida compra'));
        $form->text('valor_venda', __('Valor venda'));
        $form->text('frete', __('Frete'));
        $form->text('icms', __('Icms'));
        $form->text('lucro', __('Lucro'));
        $form->text('cliente', __('Cliente'));

        return $form;
    }
}
