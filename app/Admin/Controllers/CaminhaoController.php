<?php

namespace App\Admin\Controllers;

use \App\Models\Caminhao;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use Illuminate\Http\Request;


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

    public function listCaminhoes()
    {
        $contacts = Caminhao::all();
        $columnMapping = (new Caminhao())->columnMapping;

        return view('pages.caminhoes', compact('contacts', 'columnMapping'));
    }

    public function save(Request $request)
    {
        // Valide os dados recebidos do formulário, por exemplo:
        $validatedData = $request->validate([
            'placa' => 'required',
            'data_frete' => 'required',
            'valor_combustivel' => 'required',
            'km_inicial' => 'required',
            'valor_frete' => 'required',
            'valor_manutencao' => 'required',
            // Adicione outras validações conforme necessário
        ]);
    
        // Crie um novo registro de caminhão com os dados validados
        $caminhao = new Caminhao();
        $caminhao->placa = $validatedData['placa'];
        $caminhao->data_frete = $validatedData['data_frete'];
        $caminhao->valor_combustivel = $validatedData['valor_combustivel'];
        $caminhao->km_inicial = $validatedData['km_inicial'];
        $caminhao->valor_frete = $validatedData['valor_frete'];
        $caminhao->valor_manutencao = $validatedData['valor_manutencao'];
        // Adicione outras atribuições conforme necessário
        $caminhao->save();
    
        return response()->json(['message' => 'Registro de caminhão criado com sucesso']);
    }
    

    public function updateReport(Request $request, $id)
    {
        $caminhao = Caminhao::find($id);
        if (!$caminhao) {
            return response()->json(['message' => 'Caminhao não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'placa' => 'required',
            'data_frete' => 'required',
            'valor_combustivel' => 'required',
            'km_inicial' => 'required',
            'valor_frete' => 'required',
            'valor_manutencao' => 'required',
        ]);

        $caminhao = new Caminhao();
        $caminhao->placa = $validatedData['placa'];
        $caminhao->data_frete = $validatedData['data_frete'];
        $caminhao->valor_combustivel = $validatedData['valor_combustivel'];
        $caminhao->km_inicial = $validatedData['km_inicial'];
        $caminhao->valor_frete = $validatedData['valor_frete'];
        $caminhao->valor_manutencao = $validatedData['valor_manutencao'];

        $caminhao->save();

        return response()->json(['message' => 'Caminhao atualizado com sucesso']);
    }

    public function delete($id)
    {
        $madeira = Caminhao::find($id);

        if (!$madeira) {
            return response()->json(['message' => 'Relatorio não encontrado'], 404);
        }

        $madeira->delete();

        return response()->json(['message' => 'Relatorio excluído com sucesso']);
    }

    protected function detail($id)
    {
        $show = Caminhao::findOrFail($id);
        return response()->json($show, 200);
    }
}
