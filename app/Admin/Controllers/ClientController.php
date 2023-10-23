<?php

namespace App\Admin\Controllers;

use \App\Models\Client;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class ClientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Cliente';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

     public function listClient()
     {
         $contacts = Client::all();
         $columnMapping = (new Client())->columnMapping;
     
         return view('table', compact('contacts', 'columnMapping'));
     }
     
    
    public function testeClient()
    {
        $contacts = Client::all();
        return response()->json($contacts);
    }

    protected function grid()
    {
        $grid = new Grid(new Client());
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(view('tabs'));
        });

        $script = <<<'SCRIPT'
        <script>
            var tabs = document.getElementById('tabs');
            var appDiv = document.getElementById('app');
            appDiv.insertBefore(tabs, appDiv.children[2]);
        </script>
    SCRIPT;

        $grid->tools(function (Grid\Tools $tools) use ($script) {
            $tools->append($script);
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));



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
        $show = new Show(Client::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Client());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->phonenumber('phone', __('Phone'));

        return $form;
    }
}