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
        $columns = [
            ["name" => "Nome", "mask" => null],
            ["name" => "Email", "mask" => null],
            ["name" => "Telefone", "mask" => "phone"],
            ["name" => "Documento", "mask" => "cpf_cnpj"],
            ["name" => "Estado", "mask" => null],
            ["name" => "Cidade", "mask" => null]
        ];
        $data = Fornecedor::all();
        $columnMapping = (new Fornecedor())->columnMapping;

        // Carrega o conteúdo do arquivo table-component.blade.php
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
        ]);



        // Crie um novo cliente com os dados validados
        $fornecedor = new Fornecedor();
        $fornecedor->name = $validatedData['name'];
        $fornecedor->email = $validatedData['email'];
        $fornecedor->phone = $validatedData['phone'];
        $fornecedor->documento = $validatedData['documento'];
        $fornecedor->estado = $validatedData['estado'];
        $fornecedor->cidade = $validatedData['cidade'];

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
        // Find the client by ID
        $fornecedor = Fornecedor::find($id);

        // Check if client exists
        if (!$fornecedor) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'documento' => 'required',
            'estado' => 'required',
            'cidade' => 'required',
        ]);

        // Update the client details with validated data
        $fornecedor->name = $validatedData['name'];
        $fornecedor->email = $validatedData['email'];
        $fornecedor->phone = $validatedData['phone'];
        $fornecedor->documento = $validatedData['documento'];
        $fornecedor->estado = $validatedData['estado'];
        $fornecedor->cidade = $validatedData['cidade'];
        $fornecedor->save();

        $columnMapping = (new Fornecedor())->columnMapping;


        return response()->json(['message' => 'Fornecedor atualizado com sucesso', 'data' => $fornecedor, 'columnMapping' => $columnMapping]);
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
