@extends('admin::index')

@section('content')
@php
$body_classes = ''; // Defina as classes do corpo conforme necessário
$_user_ = '';
$tabConfig = [
    [
        'title' => 'Vendas Madeira',
        'id' => 'madeira',
        'routeName' => 'listFornecedor',
        'onClickFunction' => '()=>{}'
    ],
];
@endphp
<script src="{{ asset('js/operationAjax.js')}}"></script>
<script src="{{ asset('utils/mask.js') }}"></script>
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
        <!-- <button class="btn btn-primary btn-cadastrar" data-toggle="modal" data-target="addCliente" id="btnCadastrarCliente" onclick="openModalAction('new')">Cadastrar +</button> -->
        <button class="btn btn-primary btn-cadastrar" data-toggle="modal" data-target="addCliente" id="btnCadastrarCliente">Cadastrar +</button>

      </div>

      <!-- Modal -->

      <!-- Container com fundo branco para a tabela e filtro -->
      <div class="content-container px-3 pb-3" id="containerTable" style="background-color: white;">
        @include('components.table', [
          'columns' => [
              ["name" => "Cliente", "mask" => null],
              ["name" => "Data Venda", "mask" => "date"],
              ["name" => "Valor Total Venda", "mask" => "currency"],
              ["name" => "Lucro", "mask" => "currency"]
            ],
          'data' => $contacts,
          'columnMapping' => $columnMapping,
          'temRelatorio' => true
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
// Função para abrir o modal
// Adicione um event listener para a aba Clientes


function getModalContentForMode(mode, data) {
    switch (mode) {
        case "view":
            return `@include('components.modalCreate', [
              "sections" => [
                    [
                        "title" => "Tipo de Madeira",
                        "inputs" => [
                            ["name" => "Tipo Madeira", "mask" => null]  // Assumindo que não é necessária uma máscara específica para tipos de madeira
                        ]
                    ],
                    [
                        "title" => "Informações da Venda",
                        "inputs" => [
                            ["name" => "Frete", "mask" => "currency"],  // Para valores monetários
                            ["name" => "ICMS", "mask" => "currency"],  // Para porcentagens, se aplicável
                            ["name" => "Data Venda", "mask" => "datetime"]  // Para datas
                        ]
                    ],
                ],
                "searchClient" => "true",
                "mode" => "view",
                "data" => [
                    "Tipo Madeira" => "` + data.tipo_madeira + `",
                    "Data Venda" => "` + data.data_venda + `",
                    "Valor Venda" => "` + data.valor_venda + `",
                    "Frete" => "` + data.frete + `",
                    "ICMS" => "` + data.icms + `",
                    "Cliente" => "` + data.cliente + `",
                    "Quantidade Venda" => "`+ data.quantidade_venda +`"
                ]
            ])`;

        case "edit":
            let modalContent = `@include('components.modalCreate', [
              "sections" => [
                    [
                        "title" => "Informações da compra",
                        "inputs" => [
                          [
                              "name" => "Tipos madeira",
                              "inputComponent" => "true"
                          ]
                        ]
                    ],
                    [
                        "title" => "Informações da Venda",
                        "inputs" => [
                            ["name" => "Frete", "mask" => "currency"],  // Para valores monetários
                            ["name" => "ICMS", "mask" => "currency"],  // Para porcentagens, se aplicável
                            ["name" => "Data Venda", "mask" => "datetime"]  // Para datas
                        ]
                    ],
                ],
                "searchClient" => "true",
                "mode" => "edit",
                "data" => [
                    "Tipo Madeira" => "` + data.tipo_madeira + `",
                    "Data Venda" => "` + data.data_venda + `",
                    "Valor Venda" => "` + data.valor_venda + `",
                    "Frete" => "` + data.frete + `",
                    "ICMS" => "` + data.icms + `",
                    "Cliente" => "` + data.cliente + `",
                    "Quantidade Venda" => "`+ data.quantidade_venda +`"
                ]
            ])`;
            return modalContent.replace('onclick="update()"', 'onclick="update(' + data.id + ')"');

        case "new":
            return `@include('components.modalCreate', [
              "sections" => [
                      [
                          "title" => "Informações da compra",
                          "inputs" => [
                            [
                                "name" => "Tipos madeira",
                                "inputComponent" => "true"
                            ]
                          ]
                      ],
                      [
                          "title" => "Informações da Venda",
                          "inputs" => [
                              ["name" => "Frete", "mask" => "currency"],  // Para valores monetários
                              ["name" => "ICMS", "mask" => "currency"],  // Para porcentagens, se aplicável
                              ["name" => "Data Venda", "mask" => "datetime"]  // Para datas
                          ]
                      ]
                  ],
                "searchClient" => "true",
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
    var clienteId = parseInt(document.getElementById('searchClientInput').getAttribute('data-client-id'));
    var dataVenda = formatDateToISO(document.getElementById('inputDataVenda').value);
    var frete = unmaskCurrencyValue(document.getElementById('inputFrete').value);
    var icms = unmaskCurrencyValue(document.getElementById('inputICMS').value);

    var somaValoresCompra = 0;
    var somaValoresVenda = 0;

    var tiposMadeira = document.querySelectorAll('.inputTipoMadeira');
    var valoresCompraMadeira = document.querySelectorAll('.inputValorMadeira');
    var valoresVendaMadeira = document.querySelectorAll('.inputValorVenda');
    var quantidadesVendaMadeira = document.querySelectorAll(".inputQuantidadeVenda");


    var comprasMadeira = [];

    for (var i = 0; i < tiposMadeira.length; i++) {
        var valorCompra = unmaskCurrencyValue(valoresCompraMadeira[i].value);
        var valorVenda = unmaskCurrencyValue(valoresVendaMadeira[i].value);
        var quantidadeVenda = parseInt(quantidadesVendaMadeira[i].value);

        if (tiposMadeira[i].value !== "" && valorCompra !== null && valorVenda !== null && quantidadeVenda !== null) {
            var compra = {
                tipo_madeira: tiposMadeira[i].value,
                valo_compra: valorCompra,
                valor_venda: valorVenda,
                quantidade_venda: quantidadeVenda,
            };
            comprasMadeira.push(compra);
            somaValoresCompra += valorCompra; // Acumula o valor de compra
            somaValoresVenda += valorVenda;
        }

        
    }

    var lucro = parseFloat(somaValoresVenda) - (parseFloat(icms) + parseFloat(frete) + parseFloat(somaValoresCompra));

    const data = {
        client_id: clienteId,
        data_venda: dataVenda,
        frete: frete,
        icms: icms,
        lucro: lucro,
        valor_total_venda: parseFloat(somaValoresVenda),
        compras_madeira: comprasMadeira
    };

    return data;
}



window.create = async function () {
  try {
    const data = getModalInputValues();
    console.log(data)
    await createItem('madeira', data); // usando a função createItem
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
    const data = await retrieveItem('madeira', id); // usando a função retrieveItem
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

window.update = async function (relatorioId) {
  try {
    const data = getModalInputValues();
    await updateItem('madeira', relatorioId, data); // usando a função updateItem
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
    const data = await retrieveItem('madeira', id); // usando a função retrieveItem
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

window.deleteData = async function(clientId) {
  try {
    await deleteItem('madeira', clientId); // usando a função deleteItem

    modalSuccess("Relatorio excluido com sucesso");
    setTimeout(function() {
        location.reload();
    }, 1000);

  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao excluir o cliente');
  }
}

window.downloadPDF = function (id) {
    // Abrir o PDF em uma nova aba
    var pdfWindow = window.open(`download/${id}`);

    // Tenta acionar a impressão quando o PDF estiver carregado
    pdfWindow.onload = function() {
        // Verifica se o conteúdo é um PDF
        if (pdfWindow.document.contentType === 'application/pdf') {
            pdfWindow.print();
        }
    };
}




</script>
<script src="{{ asset('utils/eventButtonTable.js')}}"></script>
<script src="{{ asset('js/searchClient.js')}}"></script>;


@endsection