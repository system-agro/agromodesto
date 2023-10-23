<?php

namespace App\Admin\Controllers;

use \App\Models\Fornecedor;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class FornecedorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Fornecedor';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Fornecedor());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('document', __('Document'));
        $grid->column('phone', __('Phone'));
        $grid->column('email', __('Email'));
        $grid->column('state', __('State'));
        $grid->column('district', __('District'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    // public function listFornecedor()
    // {
    //     $contacts = Fornecedor::all();
    //     $columnMapping = (new Fornecedor())->columnMapping;

    //     $data = [
    //         "contacts" => $contacts,
    //         "columnMapping" => $columnMapping
    //     ];

    //     $tableComponentContent = view('components.table', $data)->render()->getContent();

    //     return response()->json(['tableComponentContent' => $tableComponentContent]);
    // }

    public function listFornecedor()
    {
        $columns = ['Nome', 'Email', 'Telefone', 'Documento', 'Estado', 'Bairro'];
        $data = Fornecedor::all();
        $columnMapping = (new Fornecedor())->columnMapping;

        // Carregue o conteúdo do arquivo table-component.blade.php
        $tableComponentContent = view('components.table', compact('columns', 'columnMapping', 'data'))->render();

        return response()->json(['tableComponentContent' => $tableComponentContent]);
    }



    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Fornecedor::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('document', __('Document'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('state', __('State'));
        $show->field('district', __('District'));
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
        $form = new Form(new Fornecedor());

        $form->text('name', __('Name'));
        $form->text('document', __('Document'));
        $form->phonenumber('phone', __('Phone'));
        $form->email('email', __('Email'));
        $form->text('state', __('State'));
        $form->text('district', __('District'));

        return $form;
    }
}
