<?php

namespace App\Admin\Controllers;

use \App\Models\Gado;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class GadoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gado';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Gado());

        $grid->column('id', __('Id'));
        $grid->column('cliente', __('Cliente'));
        $grid->column('data_venda', __('Data venda'));
        $grid->column('valor_venda', __('Valor venda'));
        $grid->column('comissao', __('Comissao'));
        $grid->column('valor_frete', __('Valor frete'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }
    public function listGados()
    {
        $contacts = Gado::all();
        $columnMapping = (new Gado())->columnMapping;

        return view('pages.gados', compact('contacts', 'columnMapping'));
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Gado::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cliente', __('Cliente'));
        $show->field('data_venda', __('Data venda'));
        $show->field('valor_venda', __('Valor venda'));
        $show->field('comissao', __('Comissao'));
        $show->field('valor_frete', __('Valor frete'));
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
        $form = new Form(new Gado());

        $form->text('cliente', __('Cliente'));
        $form->datetime('data_venda', __('Data venda'))->default(date('Y-m-d H:i:s'));
        $form->text('valor_venda', __('Valor venda'));
        $form->text('comissao', __('Comissao'));
        $form->text('valor_frete', __('Valor frete'));

        return $form;
    }

    public function save(Request $request)
    {
        // Valide os dados recebidos do formulário, por exemplo:
        $validatedData = $request->validate([
            'cliente' => 'required',
            'data_venda' => 'required',
            'valor_venda' => 'required',
            'comissao' => 'required',
            'valor_frete' => 'required',
        ]);

        // Crie um novo cliente com os dados validados
        $gado = new Gado();
        $gado->cliente = $validatedData['cliente'];
        $gado->data_venda = $validatedData['data_venda'];
        $gado->valor_venda = $validatedData['valor_venda'];
        $gado->comissao = $validatedData['comissao'];
        $gado->valor_frete = $validatedData['valor_frete'];
        $gado->save();

        return response()->json(['message' => 'Registro de venda de gado criado com sucesso']);
    }
}
