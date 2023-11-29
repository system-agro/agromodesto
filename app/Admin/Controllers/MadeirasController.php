<?php

namespace App\Admin\Controllers;

use \App\Models\Madeiras;
use \App\Models\CompraMadeira;
use Barryvdh\DomPDF\Facade\Pdf;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use Illuminate\Http\Request;
use Carbon\Carbon;


class MadeirasController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Madeiras';
    public function listMadeira()
    {
        $contacts = Madeiras::all();
        $columnMapping = (new Madeiras())->columnMapping;

        return view('pages.madeiras', compact('contacts', 'columnMapping'));
    }
    public function save(Request $request)
    {
        // Inicia uma transação
        \DB::beginTransaction();
        try {
            // Validação dos dados de madeira
            $validatedData = $request->validate([
                'data_venda' => 'required',
                'frete' => 'required',
                'icms' => 'required',
                'lucro' => 'required',
                'cliente' => 'required',
                'valor_total_venda' => 'required',
                // Assumindo que 'compras_madeira' é um array de compras
                'compras_madeira' => 'required|array',
                'compras_madeira.*.tipo_madeira' => 'required',
                'compras_madeira.*.valo_compra' => 'required',
                'compras_madeira.*.valor_venda' => 'required',
                'compras_madeira.*.quantidade_venda' => 'required',
                // Inclua outras validações necessárias para os itens de compra
            ]);

            // Cria o registro de madeira
            $madeira = new Madeiras($validatedData);
            $madeira->save();

            // Cria os registros de compra_madeira
            foreach ($validatedData['compras_madeira'] as $compraData) {
                $compra = new CompraMadeira($compraData);
                $madeira->comprasMadeira()->save($compra);
            }

            // Se tudo estiver ok, confirma as operações no banco de dados
            \DB::commit();

            return response()->json(['message' => 'Registro de venda e compra de madeira criado com sucesso'], 200);
        } catch (\Throwable $e) {
            // Em caso de erro, desfaz as operações
            \DB::rollback();

            // Retorna uma resposta de erro
            return response()->json(['message' => 'Erro ao registrar venda e compra de madeira', 'error' => $e->getMessage()], 500);
        }
    }




    protected function detail($id)
    {
        $show = Madeiras::findOrFail($id);
        return response()->json($show, 200);
    }

    public function updateReport(Request $request, $id)
    {
        // Find the madeira by ID
        $madeira = Madeiras::find($id);

        // Check if madeira exists
        if (!$madeira) {
            return response()->json(['message' => 'Madeira não encontrada'], 404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'data_venda' => 'required',
            'valor_venda' => 'required',
            'quantidade_venda' => 'required',
            'frete' => 'required',
            'icms' => 'required',
            'lucro' => 'required',
            'cliente' => 'required',
        ]);

        // Update the madeira details with validated data
        $madeira->data_venda = $validatedData['data_venda'];
        $madeira->valor_venda = $validatedData['valor_venda'];
        $madeira->quantidade_venda = $validatedData['quantidade_venda'];
        $madeira->frete = $validatedData['frete'];
        $madeira->icms = $validatedData['icms'];
        $madeira->lucro = $validatedData['lucro'];
        $madeira->cliente = $validatedData['cliente'];
        $madeira->save();

        return response()->json(['message' => 'Relatório de madeira atualizado com sucesso']);
    }

    public function delete($id)
    {
        $madeira = Madeiras::find($id);

        if (!$madeira) {
            return response()->json(['message' => 'Relatorio não encontrado'], 404);
        }

        $madeira->delete();

        return response()->json(['message' => 'Relatorio excluído com sucesso']);
    }

    protected function form()
    {
        $form = new Form(new Madeiras());

        $form->date('data_venda', __('Data venda'))->default(date('Y-m-d'));
        $form->text('valor_venda', __('Valor venda'));
        $form->text('frete', __('Frete'));
        $form->text('icms', __('Icms'));
        $form->text('lucro', __('Lucro'));
        $form->text('cliente', __('Cliente'));

        return $form;
    }

    public function generatePDF($id)
    {
        $madeira = Madeiras::findOrFail($id);
        $pdf = PDF::loadView('templates.pdf', ['madeira' => $madeira]);
    
        // Para abrir o PDF no navegador em vez de baixar
        return $pdf->stream('your_pdf_file.pdf', array("Attachment" => false));
    }
    

    public function lucroMensalMadeira()
    {
        $inicioDoMes = Carbon::now()->startOfMonth();
        $fimDoMes = Carbon::now()->endOfMonth();
        $mesAtual = $inicioDoMes->locale('pt_BR')->isoFormat('MMMM');
        $lucroTotal = Madeiras::whereBetween('data_venda', [$inicioDoMes, $fimDoMes])
            ->sum('lucro');



        return view('components.card-gestao-lucro', ['lucroTotal' => $lucroTotal, "mesAtual" => $mesAtual, "produto"=>"Madeira"]);

    }

}
