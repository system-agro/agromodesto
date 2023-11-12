<?php

namespace App\Admin\Controllers;

use \App\Models\Madeiras;
use Barryvdh\DomPDF\Facade\Pdf;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use Illuminate\Http\Request;


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
        // Valide os dados recebidos do formulário para madeira
        $validatedData = $request->validate([
            'tipo_madeira' => 'required',
            'data_venda' => 'required',
            'valor_venda' => 'required',
            'quantidade_venda' => 'required',
            'frete' => 'required',
            'icms' => 'required',
            'lucro' => 'required',
            'cliente' => 'required',
        ]);

        // Crie um novo registro de venda de madeira com os dados validados
        $madeira = new Madeiras(); // Substitua 'Madeira' pelo nome real do seu modelo
        $madeira->tipo_madeira = $validatedData['tipo_madeira'];
        $madeira->data_venda = $validatedData['data_venda'];
        $madeira->valor_venda = $validatedData['valor_venda'];
        $madeira->quantidade_venda = $validatedData['quantidade_venda'];
        $madeira->frete = $validatedData['frete'];
        $madeira->icms = $validatedData['icms'];
        $madeira->lucro = $validatedData['lucro'];
        $madeira->cliente = $validatedData['cliente'];
        $madeira->save();

        return response()->json(['message' => 'Registro de venda de madeira criado com sucesso']);
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
            'tipo_madeira' => 'required',
            'data_venda' => 'required',
            'valor_venda' => 'required',
            'quantidade_venda' => 'required',
            'frete' => 'required',
            'icms' => 'required',
            'lucro' => 'required',
            'cliente' => 'required',
        ]);

        // Update the madeira details with validated data
        $madeira->tipo_madeira = $validatedData['tipo_madeira'];
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

        $form->text('tipo_madeira', __('Tipo madeira'));
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
        return $pdf->download('your_pdf_file.pdf');
    }
}
