@extends('admin::index')

@section('content')
@php
$body_classes = ''; // Defina as classes do corpo conforme necessário
$_user_ = '';
$tabConfig = [
    [
        'title' => 'Vendas Gado',
        'id' => 'gados',
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
        'columns' => ['Cliente', 'Data Venda', 'Valor Venda', 'Comissão', 'Valor Frete'],
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
                        "title" => "Informações Pessoais",
                        "inputs" => ["Nome"]
                    ],
                    [
                        "title" => "Contatos",
                        "inputs" => ["Email", "Telefone"]
                    ]
                ],
                "mode" =>  "view",
                "data" => [
                    "Nome" => "` + data.name + `",
                    "Email" => "` + data.email + `",
                    "Telefone" => "` + data.phone + `"
                ]
            ])`;

        case "edit":
            let modalContent = `@include('components.modalCreate', [
                "sections" => [
                    [
                        "title" => "Informações Pessoais",
                        "inputs" => ["Nome"]
                    ],
                    [
                        "title" => "Contatos",
                        "inputs" => ["Email", "Telefone"]
                    ]
                ],
                "mode" =>  "edit",
                "data" => [
                    "Nome" => "` + data.name + `",
                    "Email" => "` + data.email + `",
                    "Telefone" => "` + data.phone + `"
                ]
            ])`;
            return modalContent.replace('onclick="updateClient()"', 'onclick="updateClient(' + data.id + ')"');

        case "new":
            return `@include('components.modalCreate', [
                "sections" => [
                    [
                        "title" => "Informações do cliente",
                        "inputs" => ["Nome"]
                    ],
                    [
                        "title" => "Detalhes da Venda",
                        "inputs" => ["Data Venda", "Valor Venda", "Comissão", "Valor Frente"]
                    ]
                ],
                "mode" =>  "new",
                "data" => []
            ])`;

        default:
            return "";
    }
}

function getModalInputValues() {
    
    var cliente = document.getElementById('inputNome').value;
    var date = document.getElementById('inputDataVenda').value;
    var venda = document.getElementById('inputValorVenda').value;
    var comissao = document.getElementById('inputComissão').value;
    var frete = document.getElementById('inputValorFrente').value;
    
    const data = {
        cliente:cliente,
        data_venda:date,
        valor_venda:venda,
        comissao:comissao,
        valor_frete:frete
    };

    return data
}


async function create() {
  try {
    const data = getModalInputValues();
    await createItem('gado', data); // usando a função createItem
    closeModal();
    modalSuccess("Cliente cadastrado com sucesso");
    setTimeout(function() {
        location.reload();
    }, 1000);
    // Limpe o formulário ou atualize a tabela, conforme necessário

  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao criar o cliente');
  }
}

</script>
@endsection