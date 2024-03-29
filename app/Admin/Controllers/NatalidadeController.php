<?php

namespace App\Admin\Controllers;

use \App\Models\Natalidade;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class NatalidadeController extends AdminController
{
  /**
   * Title for current resource.
   *
   * @var string
   */
  protected $title = 'Natalidade';
  public function listNatalidade()
  {
    $columns = [
      ["name" => "Numeracao Animal", "mask" => null],
      ["name" => "Tipo", "mask" => null],
      ["name" => "Condicao", "mask" => null],
      ["name" => "Data Inseminacao", "mask" => "date"],
      ["name" => "Data Gestacao", "mask" => "date"]
    ];
    $data = Natalidade::all();
    $columnMapping = (new Natalidade())->columnMapping;

    foreach ($data as $natalidade) {
      $natalidade->gestante = $natalidade->gestante == 1 ? 'Sim' : 'Não';
    }

    // Carrega o conteúdo do arquivo table-component.blade.php
    $tableComponentContent = view('components.table', compact('columns', 'columnMapping', 'data'))->render();

    return response()->json(['tableComponentContent' => $tableComponentContent]);
  }


  public function save(Request $request)
  {
    // Valide os dados recebidos do formulário, por exemplo:
    $validatedData = $request->validate([
      'numeracao_animal' => 'required',
      // campo para a numeração do animal
      'tipo_animal' => 'required',
      // campo para o tipo de animal
      'gestante' => 'required',
      // campo para a condição gestante
      'data_inseminacao' => 'date',
      // campo para a data de inseminação
      'data_gestacao' => 'date',
      // campo para a data de gestação
    ]);

    // Crie um novo registro de natalidade com os dados validados
    $natalidade = new Natalidade(); // Substitua 'Natalidade' pelo nome real da sua classe de modelo
    $natalidade->numeracao_animal = $validatedData['numeracao_animal'];
    $natalidade->tipo_animal = $validatedData['tipo_animal'];
    $natalidade->gestante = $validatedData['gestante'];
    $natalidade->data_inseminacao = $validatedData['data_inseminacao'];
    $natalidade->data_gestacao = $validatedData['data_gestacao'];

    $natalidade->save();

    $natalidade->gestante = $natalidade->gestante == 0 ? 'Não' : 'Sim';
    $response = $natalidade;

    // Use o mapeamento de colunas se necessário, ou remova se não for usar
    $columnMapping = $natalidade->columnMapping ?? null;

    // A resposta inclui o objeto natalidade criado e, opcionalmente, o mapeamento de colunas
    return response()->json(compact('response', 'columnMapping'));
  }

  public function updateNatalidade(Request $request, $id)
  {
    // Encontre o registro de natalidade pelo ID
    $natalidade = Natalidade::find($id);

    // Verifique se o registro de natalidade existe
    if (!$natalidade) {
      return response()->json(['message' => 'Registro de natalidade não encontrado'], 404);
    }

    // Valide os dados recebidos do formulário
    $validatedData = $request->validate([
      'numeracao_animal' => 'required',
      'tipo_animal' => 'required',
      'gestante' => 'required',
      'data_inseminacao' => 'date',
      'data_gestacao' => 'date',
    ]);

    // Atualize os detalhes do registro de natalidade com os dados validados
    $natalidade->numeracao_animal = $validatedData['numeracao_animal'];
    $natalidade->tipo_animal = $validatedData['tipo_animal'];
    $natalidade->gestante = $validatedData['gestante'];
    $natalidade->data_inseminacao = $validatedData['data_inseminacao'];
    $natalidade->data_gestacao = $validatedData['data_gestacao'];
    $natalidade->save();

    // Se estiver utilizando mapeamento de colunas, obtenha-o do modelo
    $columnMapping = $natalidade->columnMapping ?? null;

    // A resposta inclui o registro de natalidade atualizado e, opcionalmente, o mapeamento de colunas
    return response()->json([
      'message' => 'Registro de natalidade atualizado com sucesso',
      'data' => $natalidade,
      'columnMapping' => $columnMapping
    ]);
  }

  public function detail($id)
  {
    try {
      // Tente encontrar o registro de natalidade pelo ID fornecido
      $natalidade = Natalidade::findOrFail($id);
      $natalidade->gestante = $natalidade->gestante == 0 ? 'Não' : 'Sim';

      // Se encontrado, retorne o registro com status HTTP 200
      return response()->json($natalidade, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      // Se o registro de natalidade não for encontrado, retorne uma mensagem de erro
      return response()->json(['success' => false, 'message' => 'Registro de natalidade não encontrado.']);
    }
  }

  public function delete($id)
  {
    try {
      // Tente encontrar o registro de natalidade pelo ID fornecido
      $natalidade = Natalidade::find($id);
      // Se encontrado, exclua o registro
      $natalidade->delete();
      // Retorne uma mensagem de sucesso com a confirmação da exclusão
      return response()->json(['success' => true, 'message' => 'Registro de natalidade excluído com sucesso.']);
    } catch (\Exception $e) {
      // Se ocorrer algum erro durante a exclusão, retorne uma mensagem de erro
      return response()->json(['success' => false, 'message' => 'Erro ao excluir registro de natalidade.']);
    }
  }

  public function listFilterNatalidade()
  {
    $hoje = new \DateTime(); // Data atual

    $filteredData = Natalidade::all()->filter(function ($natalidade) use ($hoje) {
      $dataGestacao = new \DateTime($natalidade->data_gestacao);

      // Verifica se a data de gestação ainda não passou
      $gestacaoNaoPassou = $dataGestacao > $hoje;

      // Calcula a diferença de dias entre hoje e a data de gestação
      $diferencaDias = $hoje->diff($dataGestacao)->days;

      // Retorna se a gestação não passou e faltam até 30 dias
      return $gestacaoNaoPassou && $diferencaDias <= 30;
    })->map(function ($natalidade) use ($hoje) {
      $dataGestacao = new \DateTime($natalidade->data_gestacao);

      // Calcula a diferença de dias entre hoje e a data de gestação
      $diferencaDias = $hoje->diff($dataGestacao)->days;

      return [
        'natalidade' => $natalidade,
        'dias_ate_gestacao' => $diferencaDias
      ];
    });

    return view('components.card-gestao-natalidade', ['data' => $filteredData]);
  }



}
