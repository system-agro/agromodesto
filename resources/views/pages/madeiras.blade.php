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
<script src="{{ asset('utils/modals.js')}}"></script>
<!-- Seu conteúdo aqui -->
<style>
/* Estilos para o modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  display: flex;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

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
        'columns' => ['Cliente', 'Data Venda', 'Valor Venda', 'Lucro'],
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
                        "inputs" => ["Tipo Madeira"]
                    ],
                    [
                        "title" => "Informações da Compra",
                        "inputs" => ["Data Venda", "Valor Compra", "Quantidade Compra"]
                    ],
                    [
                        "title" => "Informações da Venda",
                        "inputs" => ["Valor Venda", "Frete", "ICMS", "Lucro"]
                    ],
                    [
                        "title" => "Dados do Cliente",
                        "inputs" => ["Cliente"]
                    ]
                ],
                "mode" => "view",
                "data" => [
                    "Tipo Madeira" => "` + data.tipo_madeira + `",
                    "Data Venda" => "` + data.data_venda + `",
                    "Valor Compra" => "` + data.valor_compra + `",
                    "Quantidade Compra" => "` + data.quantida_compra + `",
                    "Valor Venda" => "` + data.valor_venda + `",
                    "Frete" => "` + data.frete + `",
                    "ICMS" => "` + data.icms + `",
                    "Lucro" => "` + data.lucro + `",
                    "Cliente" => "` + data.cliente + `"
                ]
            ])`;

        case "edit":
            let modalContent = `@include('components.modalCreate', [
              "sections" => [
                    [
                        "title" => "Tipo de Madeira",
                        "inputs" => ["Tipo Madeira"]
                    ],
                    [
                        "title" => "Informações da Compra",
                        "inputs" => ["Data Venda", "Valor Compra", "Quantidade Compra"]
                    ],
                    [
                        "title" => "Informações da Venda",
                        "inputs" => ["Valor Venda", "Frete", "ICMS", "Lucro"]
                    ],
                    [
                        "title" => "Dados do Cliente",
                        "inputs" => ["Cliente"]
                    ]
                ],
                "mode" => "edit",
                "data" => [
                    "Tipo Madeira" => "` + data.tipo_madeira + `",
                    "Data Venda" => "` + data.data_venda + `",
                    "Valor Compra" => "` + data.valor_compra + `",
                    "Quantidade Compra" => "` + data.quantida_compra + `",
                    "Valor Venda" => "` + data.valor_venda + `",
                    "Frete" => "` + data.frete + `",
                    "ICMS" => "` + data.icms + `",
                    "Lucro" => "` + data.lucro + `",
                    "Cliente" => "` + data.cliente + `"
                ]
            ])`;
            return modalContent.replace('onclick="update()"', 'onclick="update(' + data.id + ')"');

        case "new":
            return `@include('components.modalCreate', [
              "sections" => [
                    [
                        "title" => "Tipo de Madeira",
                        "inputs" => ["Tipo Madeira"]
                    ],
                    [
                        "title" => "Informações da Compra",
                        "inputs" => ["Data Venda", "Valor Compra", "Quantidade Compra"]
                    ],
                    [
                        "title" => "Informações da Venda",
                        "inputs" => ["Valor Venda", "Frete", "ICMS", "Lucro"]
                    ],
                    [
                        "title" => "Dados do Cliente",
                        "inputs" => ["Cliente"]
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
    var dataVenda = document.getElementById('inputDataVenda').value;
    var valorCompra = document.getElementById('inputValorCompra').value;
    var quantidadeCompra = document.getElementById('inputQuantidadeCompra').value;
    var valorVenda = document.getElementById('inputValorVenda').value;
    var frete = document.getElementById('inputFrete').value;
    var icms = document.getElementById('inputICMS').value;
    var lucro = document.getElementById('inputLucro').value;
    var cliente = document.getElementById('inputCliente').value;
    
    const data = {
        tipo_madeira: tipoMadeira,
        data_venda: dataVenda,
        valor_compra: valorCompra,
        quantida_compra: quantidadeCompra,
        valor_venda: valorVenda,
        frete: frete,
        icms: icms,
        lucro: lucro,
        cliente: cliente
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

</script>
@endsection