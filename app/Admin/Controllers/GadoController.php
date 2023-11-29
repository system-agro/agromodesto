<?php

namespace App\Admin\Controllers;

use \App\Models\Gado;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


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
            "lucro" => "required",
            "valor_compra" => "required"
        ]);

        // Crie um novo cliente com os dados validados
        $gado = new Gado();
        $gado->cliente = $validatedData['cliente'];
        $gado->data_venda = $validatedData['data_venda'];
        $gado->valor_venda = $validatedData['valor_venda'];
        $gado->comissao = $validatedData['comissao'];
        $gado->valor_frete = $validatedData['valor_frete'];
        $gado->lucro = $validatedData['lucro'];
        $gado->valor_compra = $validatedData['valor_compra'];
        $gado->save();

        $response = $gado;
        $columnMapping = (new Gado())->columnMapping;
        
        return response()->json(compact('response', 'columnMapping'));
    }

    protected function detail($id)
    {
        $show = Gado::findOrFail($id);
        return response()->json($show, 200);
    }

    public function updateReport(Request $request, $id)
    {
        // Find the gado by ID
        $gado = Gado::find($id);

        // Check if gado exists
        if (!$gado) {
            return response()->json(['message' => 'Gado não encontrado'], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'cliente' => 'required',
            'data_venda' => 'required',
            'valor_venda' => 'required',
            'comissao' => 'required',
            'valor_frete' => 'required',
            "lucro" => "required",
            "valor_compra" => "required"
        ]);

        // Update the gado details with validated data
        $gado->cliente = $validatedData['cliente'];
        $gado->data_venda = $validatedData['data_venda'];
        $gado->valor_venda = $validatedData['valor_venda'];
        $gado->comissao = $validatedData['comissao'];
        $gado->valor_frete = $validatedData['valor_frete'];
        $gado->lucro = $validatedData['lucro'];
        $gado->valor_compra = $validatedData['valor_compra'];

        $gado->save();

        return response()->json(['message' => 'Gado atualizado com sucesso']);
    }
    public function delete($id)
    {
        $gado = Gado::find($id);

        if (!$gado) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $gado->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }

    public function lucroMensalGado()
    {
        $inicioDoMes = Carbon::now()->startOfMonth();
        $fimDoMes = Carbon::now()->endOfMonth();
        $mesAtual = $inicioDoMes->locale('pt_BR')->isoFormat('MMMM');
        $lucroTotal = Gado::whereBetween('data_venda', [$inicioDoMes, $fimDoMes])
            ->sum('lucro');



        return view('components.card-gestao-lucro', ['lucroTotal' => $lucroTotal, "mesAtual" => $mesAtual, "produto"=>"Gado"]);

    }

    public function generatePDF($id)
    {
        $gado = Gado::findOrFail($id);
        $pdf = PDF::loadView('templates.gados', ['gado' => $gado]);
        return $pdf->stream('relatorio_gado.pdf', array("Attachment" => false));

    }

}
