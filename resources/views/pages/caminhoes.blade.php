@extends('admin::index')

@section('content')
@php
$body_classes = ''; // Defina as classes do corpo conforme necessário
$_user_ = '';
$tabConfig = [
    [
        'title' => 'Relatorio Caminhao',
        'id' => 'caminhao',
        'routeName' => 'listFornecedor',
        'onClickFunction' => '()=>{}'
    ],
];
@endphp

<script src="{{ asset('js/operationAjax.js')}}"></script>
<script src="{{ asset('utils/modals.js')}}"></script>
<script src="{{ asset('vendor/open-admin/inputmask/inputmask.min.js') }}"></script>

<!-- Seu conteúdo aqui -->
<style>
/* Estilos para o modal */
.nav-item {
  cursor: pointer;
}

</style>
<div id="tabs">
  @include('components.tabs',  ['tabsConfig' => $tabConfig])
  @include('components.modalSuccess', ['title' => ''])
  <!-- Conteúdo das abas -->
  <div class="tab-content" id="customTabsContent">
    <!-- Conteúdo para a aba de Clientes -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
      <!-- Botão "Cadastrar +" -->
      <div id="container-button-cadastrar" class="content-container p-3">
        <button class="btn btn-primary btn-cadastrar" data-toggle="modal" data-target="addCliente" id="btnCadastrarCliente">Cadastrar +</button>
      </div>

      <!-- Modal -->

      <!-- Container com fundo branco para a tabela e filtro -->
      <div class="content-container px-3 pb-3" id="containerTable" style="background-color: white;">
      @include('components.table', [
            'columns' => [
                ["name" => "Placa", "mask" => null],
                ["name" => "Data Frete", "mask" => "date"],
                ["name" => "Valor Frete", "mask" => "currency"],
                ["name" => "Lucro", "mask" => "currency"]
            ],
            'data' => $contacts,
            'columnMapping' => $columnMapping
        ])
      </div>
    </div>

    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
      <!-- Conteúdo para a aba de Fornecedores aqui -->

      <div class="content-container px-3 pb-3" id="tabs-fon" style="background-color: white;">

      </div>
    </div>
  </div>
</div>
<!-- Seu código HTML aqui, incluindo o botão "Cadastrar +" e o modal -->
<script>

function initializeInputMasks() {
  // Esta função irá inicializar a máscara de entrada para todos os campos que têm o atributo 'data-mask'
  Inputmask().mask(document.querySelectorAll("input"));
}
// Função para abrir o modal
// Adicione um event listener para a aba Clientes
function getModalContentForMode(mode, data) {
    switch (mode) {
      case "view":
        return `@include('components.modalCreate', [
            "sections" => [
                    [
                        "title" => "Detalhes do Caminhão",
                        "inputs" => [
                            ["name" => "Placa", "mask" => "AAA-9999"],
                            ["name" => "Data Frete", "mask" => "datetime"],
                            ["name" => "Km Inicial", "mask" => null]
                        ]
                    ],
                    [
                        "title" => "Custos Operacionais",
                        "inputs" => [
                            ["name" => "Quantidade Combustivel", "mask" => null],
                            ["name" => "Valor Combustivel", "mask" => "currency"],
                            ["name" => "Valor Frete", "mask" => "currency"],
                            ["name" => "Valor Manutencao", "mask" => "currency"]
                        ]
                    ]
                ],
            "mode" => "view",
            "data" => [
                "Placa" => "` + data.placa + `",
                "Data Frete" => "` + data.data_frete + `",
                "Km Inicial" => "` + data.km_inicial + `",
                "Valor Combustivel" => "` + data.valor_combustivel + `",
                "Valor Frete" => "` + data.valor_frete + `",
                "Valor Manutencao" => "` + data.valor_manutencao + `",
                "Quantidade Combustivel" => "`+ data.quantidade_litro_combustivel +`"
            ]
          ])`;
          case "edit":
            let modalContent = `@include('components.modalCreate', [
                  "sections" => [
                        [
                            "title" => "Detalhes do Caminhão",
                            "inputs" => [
                                ["name" => "Placa", "mask" => "AAA-9999"],
                                ["name" => "Data Frete", "mask" => "datetime"],
                                ["name" => "Km Inicial", "mask" => null]
                            ]
                        ],
                        [
                            "title" => "Custos Operacionais",
                            "inputs" => [
                                ["name" => "Quantidade Combustivel", "mask" => null],
                                ["name" => "Valor Combustivel", "mask" => "currency"],
                                ["name" => "Valor Frete", "mask" => "currency"],
                                ["name" => "Valor Manutencao", "mask" => "currency"]
                            ]
                        ]
                    ],
                  "mode" => "edit",
                  "data" => [
                      "Placa" => "` + data.placa + `",
                      "Data Frete" => "` + data.data_frete + `",
                      "Km Inicial" => "` + data.km_inicial + `",
                      "Valor Combustivel" => "` + data.valor_combustivel + `",
                      "Valor Frete" => "` + data.valor_frete + `",
                      "Valor Manutencao" => "` + data.valor_manutencao + `",
                      "Quantidade Combustivel" => "`+ data.quantidade_litro_combustivel +`"
                  ]
            ])`;
            return modalContent.replace('onclick="update()"', 'onclick="update(' + data.id + ')"');
          case "new":
              return `@include('components.modalCreate', [
                  "sections" => [
                      [
                          "title" => "Detalhes do Caminhão",
                          "inputs" => [
                              ["name" => "Placa", "mask" => "AAA-****"],
                              ["name" => "Data Frete", "mask" => "datetime"],
                              ["name" => "Km Inicial", "mask" => null]
                          ]
                      ],
                      [
                          "title" => "Custos Operacionais",
                          "inputs" => [
                              ["name" => "Quantidade Combustivel", "mask" => null],
                              ["name" => "Valor Combustivel", "mask" => "currency"],
                              ["name" => "Valor Frete", "mask" => "currency"],
                              ["name" => "Valor Manutencao", "mask" => "currency"]
                          ]
                      ]
                  ],
                  "mode" => "new",
                  "data" => []
              ])`;
          default:
            return "";
    }
}

document.querySelectorAll('.btn-cadastrar').forEach(button => {
    button.addEventListener('click', () => {
      openModalAction('new', {}, getModalContentForMode);
    });
});

function getModalInputValues() {
  var placa = unmaskValue(document.getElementById('inputPlaca'));
  var dataFrete = formatDateToISO(document.getElementById('inputDataFrete').value);
  var kmInicial = document.getElementById('inputKmInicial').value;
  var quantidadeCombustivel = parseFloat(document.getElementById('inputQuantidadeCombustivel').value);
  var valorFrete = unmaskCurrencyValue(document.getElementById('inputValorFrete').value);
  var valorManutencao = unmaskCurrencyValue(document.getElementById('inputValorManutencao').value);
  var valorCombustivel = unmaskCurrencyValue(document.getElementById('inputValorCombustivel').value);
  
  var valorTotalCombustivel = parseFloat(quantidadeCombustivel) * parseFloat(valorCombustivel);
  var lucro = parseFloat((valorFrete - (valorTotalCombustivel + valorManutencao))).toFixed(2);

  const data = {
      placa: placa,
      data_frete: dataFrete,
      valor_combustivel: valorCombustivel,
      km_inicial: kmInicial,
      valor_frete: valorFrete,
      valor_manutencao: valorManutencao,
      lucro: parseFloat(lucro),
      quantidade_litro_combustivel: quantidadeCombustivel
  };

  return data;
}


async function create() {
  try {
    const data = getModalInputValues();
    await createItem('caminhaos', data); // usando a função createItem
    closeModal();
    modalSuccess("Relatorio de venda de gado gerado com sucesso");
    setTimeout(function() {
        location.reload();
    }, 1000);
    // Limpe o formulário ou atualize a tabela, conforme necessário

  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao criar o relatorio');
  }
}

window.visualizarItem = async function (id) {
  try {
    const data = await retrieveItem('caminhaos', id); // usando a função retrieveItem
    if (data) {
      // Manipulate the API data here
      openModalAction('view', data, getModalContentForMode);
    } else {
      console.error('Error calling the API');
    }
  } catch (error) {
    console.error('An error occurred:', error);
  }
}

async function update(relatorioId) {
  try {
    const data = getModalInputValues();
    await updateItem('caminhaos', relatorioId, data); // usando a função updateItem
    closeModal();
    modalSuccess("Relatorio atualizado com sucesso");
    setTimeout(function() {
        location.reload();
    }, 1000);
    // Refresh the form or the table as needed

  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao atualizar o relatorio');
  }
}

window.onEditModal = async function (id) {
  try {
    const data = await retrieveItem('caminhaos', id); // usando a função retrieveItem
    if (data) {
      // Manipulate the API data here
      openModalAction('edit', data, getModalContentForMode);
    } else {
      console.error('Error calling the API');
    }
  } catch (error) {
    console.error('An error occurred:', error);
  }
}

window.deleteData = async function (clientId) {
  try {
    await deleteItem('caminhaos', clientId); // usando a função deleteItem

    modalSuccess("Relatorio excluido com sucesso");
    setTimeout(function() {
        location.reload();
    }, 1000);

  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao excluir o cliente');
  }
}

</script>
<script src="{{ asset('utils/eventButtonTable.js')}}"></script>

@endsection