<?php

namespace App\Admin\Controllers;

use \App\Models\Fornecedor;
use Illuminate\Http\Request;
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
    public function listFornecedor()
    {
        $columns = ['Nome', 'Email', 'Telefone', 'Documento', 'Estado', 'Bairro'];
        $data = Fornecedor::all();
        $columnMapping = (new Fornecedor())->columnMapping;

        // Carregue o conteúdo do arquivo table-component.blade.php
        $tableComponentContent = view('components.table', compact('columns', 'columnMapping', 'data'))->render();

        return response()->json(['tableComponentContent' => $tableComponentContent]);
    }

    public function save(Request $request)
    {
        // Valide os dados recebidos do formulário, por exemplo:
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'documento' => 'required',
            'estado' => 'required',
            'cidade' => 'required',
            'bairro' => 'required',
        ]);



        // Crie um novo cliente com os dados validados
        $fornecedor = new Fornecedor();
        $fornecedor->name = $validatedData['name'];
        $fornecedor->email = $validatedData['email'];
        $fornecedor->phone = $validatedData['phone'];
        $fornecedor->document = $validatedData['documento'];
        $fornecedor->state = $validatedData['estado'];
        $fornecedor->district = $validatedData['cidade'];
        $fornecedor->save();

        $response = $fornecedor;

        $columnMapping = (new Fornecedor())->columnMapping;

        return response()->json(compact('response', 'columnMapping'));
    }

    public function detail($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            return response()->json($fornecedor, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Fornecedor não encontrado.']);
        }
    }

    public function delete($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->delete();
            return response()->json(['success' => true, 'message' => 'Fornecedor excluído com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir fornecedor.']);
        }
    }

    public function updateFornecedor(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'documento' => 'required',
            'estado' => 'required',
            'cidade' => 'required',
            'bairro' => 'required',
        ]);

        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->name = $validatedData['name'];
            $fornecedor->email = $validatedData['email'];
            $fornecedor->phone = $validatedData['phone'];
            $fornecedor->document = $validatedData['documento'];
            $fornecedor->state = $validatedData['estado'];
            $fornecedor->city = $validatedData['cidade']; // Ajuste se necessário
            $fornecedor->district = $validatedData['bairro']; // Ajuste se necessário
            $fornecedor->save();

            return response()->json(['success' => true, 'message' => 'Fornecedor atualizado com sucesso.', 'fornecedor' => $fornecedor]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Fornecedor não encontrado para atualização.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar fornecedor.']);
        }
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
