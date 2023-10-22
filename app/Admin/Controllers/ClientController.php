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

    public function loadClientData()
    {
        $contacts  = Client::all();
        return view('table', compact('contacts'));
        // return response()->json($clientes);
        
    }
    

    protected function grid()
    {
        $grid = new Grid(new Client());

        //     $customTabs = <<<'HTML'
        //     <ul class="nav nav-tabs" id="customTabs" role="tablist">
        //         <li class="nav-item">
        //             <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Clientes</a>
        //         </li>
        //         <li class="nav-item">
        //             <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Fornecedores</a>
        //         </li>
        //     </ul>
        //     <div class="tab-content" id="customTabsContent">
        //         <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        //             Content for Tab 1
        //         </div>
        //         <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        //             Content for Tab 2
        //         </div>
        //     </div>
        // HTML;

        // $grid->tools(function (Grid\Tools $tools) use ($customTabs) {
        //     $tools->append($customTabs);
        // });






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