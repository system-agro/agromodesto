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
<!-- <script src="{{ asset('utils/mask.js') }}"></script> -->
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
        <button class="btn btn-primary" data-toggle="modal" data-target="addCliente" id="btnCadastrarCliente" onclick="openModalAction('new')">Cadastrar
          +</button>
      </div>

      <!-- Modal -->

      <!-- Container com fundo branco para a tabela e filtro -->
      <div class="content-container px-3 pb-3" id="containerTable" style="background-color: white;">
        @include('components.table', [
          'columns' => [
              ["name" => "Cliente", "mask" => null],
              ["name" => "Tipo Madeira", "mask" => null],
              ["name" => "Data Venda", "mask" => "date"],
              ["name" => "Valor Venda", "mask" => "currency"],
              ["name" => "Quantidade Venda", "mask" => null], // Supondo que esta seja uma quantidade simples sem máscara
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
                            ["name" => "Quantidade Venda", "mask" => "decimal"],  // Para quantidades, poderia ser um número decimal
                            ["name" => "Valor Venda", "mask" => "currency"],  // Para valores monetários
                            ["name" => "Frete", "mask" => "currency"],  // Para valores monetários
                            ["name" => "ICMS", "mask" => "percentage"],  // Para porcentagens, se aplicável
                            ["name" => "Data Venda", "mask" => "datetime"]  // Para datas
                        ]
                    ],
                    [
                        "title" => "Dados do Cliente",
                        "inputs" => [
                            ["name" => "Cliente", "mask" => null]  // Assumindo que não é necessária uma máscara específica para nomes de clientes
                        ]
                    ]
                ],
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
                            ["name" => "Quantidade Venda", "mask" => "decimal"],  // Para quantidades, poderia ser um número decimal
                            ["name" => "Valor Venda", "mask" => "currency"],  // Para valores monetários
                            ["name" => "Frete", "mask" => "currency"],  // Para valores monetários
                            ["name" => "ICMS", "mask" => "percentage"],  // Para porcentagens, se aplicável
                            ["name" => "Data Venda", "mask" => "datetime"]  // Para datas
                        ]
                    ],
                    [
                        "title" => "Dados do Cliente",
                        "inputs" => [
                            ["name" => "Cliente", "mask" => null]  // Assumindo que não é necessária uma máscara específica para nomes de clientes
                        ]
                    ]
                ],
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
                              ["name" => "Quantidade Venda", "mask" => "decimal"],  // Para quantidades, poderia ser um número decimal
                              ["name" => "Valor Venda", "mask" => "currency"],  // Para valores monetários
                              ["name" => "Frete", "mask" => "currency"],  // Para valores monetários
                              ["name" => "ICMS", "mask" => "percentage"],  // Para porcentagens, se aplicável
                              ["name" => "Data Venda", "mask" => "datetime"]  // Para datas
                          ]
                      ],
                      [
                          "title" => "Dados do Cliente",
                          "inputs" => [
                              ["name" => "Cliente", "mask" => null]  // Assumindo que não é necessária uma máscara específica para nomes de clientes
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


function getModalInputValues() {
    
    var tipoMadeira = document.getElementById('inputTipoMadeira').value;
    var dataVenda = formatDateToISO(document.getElementById('inputDataVenda').value);
    var valorVenda = unmaskCurrencyValue(document.getElementById('inputValorVenda').value);
    var frete = unmaskCurrencyValue(document.getElementById('inputFrete').value);
    var icms = unmaskValue(document.getElementById('inputICMS'));
    var cliente = document.getElementById('inputCliente').value;
    var quantidadeVenda = unmaskValue(document.getElementById("inputQuantidadeVenda"))


    var valorIcms = (parseFloat(icms) / 100) * parseFloat(valorVenda);
    var lucro = parseFloat(valorVenda) - (valorIcms + parseFloat(frete));

    console.log(lucro)

    const data = {
        tipo_madeira: tipoMadeira,
        data_venda: dataVenda,
        valor_venda: valorVenda,
        frete: frete,
        icms: icms,
        lucro: lucro,
        cliente: cliente,
        quantidade_venda: quantidadeVenda
    };

    return data;
}



async function create() {
  try {
    const data = getModalInputValues();
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

async function visualizarItem(id) {
  try {
    const data = await retrieveItem('madeira', id); // usando a função retrieveItem
    if (data) {
      // Manipulate the API data here
      openModalAction('view', data, );
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

async function onEditModal(id) {
  try {
    const data = await retrieveItem('madeira', id); // usando a função retrieveItem
    if (data) {
      // Manipulate the API data here
      openModalAction('edit', data);
    } else {
      console.error('Error calling the API');
    }
  } catch (error) {
    console.error('An error occurred:', error);
  }
}

async function deleteData(clientId) {
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

async function downloadInvoice() {
    var invoiceId = '123'; // Substitua pelo ID real da fatura
    var url = `/invoices/${invoiceId}/download`; // Substitua pela URL correta conforme definida em suas rotas do Laravel

    try {
        const response = await fetch(url, {
            method: 'GET', // ou 'POST' se for necessário
            headers: {
                // Se for um método POST, você precisa enviar CSRF token e definir o 'Content-Type'
                'X-Requested-With': 'XMLHttpRequest',
                // 'X-CSRF-TOKEN': csrfToken, // Descomente e defina isso se for necessário
                // 'Content-Type': 'application/json', // Descomente e ajuste conforme necessário
            },
            // body: JSON.stringify(data), // Descomente e defina isso se for necessário enviar dados no corpo da requisição
        });

        if (response.ok) {
            // Se o servidor responder com um arquivo para download,
            // você pode pegar o blob e criar um link para download
            const blob = await response.blob();
            const downloadUrl = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = downloadUrl;
            a.download = `invoice-${invoiceId}.pdf`; // Nome do arquivo para download
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(downloadUrl);
            a.remove();
        } else {
            // Trate erros de resposta, como exibir uma mensagem para o usuário
            console.error('Download failed:', response.statusText);
        }
    } catch (error) {
        console.error('There was an error with the fetch operation:', error);
    }
}

function downloadPDF(id) {
    window.location.href =  `download/${id}`; // Substitua pela URL completa se necessário
}


</script>
@endsection