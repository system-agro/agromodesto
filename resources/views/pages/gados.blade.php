@extends('admin::index')

@section('content')
@php
$body_classes = ''; // Defina as classes do corpo conforme necessário
$_user_ = '';
$tabConfig = [
    [
        'title' => 'Gados',
        'id' => 'tabGado',
        'routeName' => 'listGados',
        'onClickFunction' => 'selectTabGado()',
        'content' => view('components.table', ['columns' => ['Cliente', 'Data Venda', 'Valor Venda', 'Comissao', 'Valor Frete', 'Lucro'], 'data' => $contacts, 'columnMapping' => $columnMapping])->render()
    ],
    [
        'title' => 'Controle de Natalidade',
        'id' => 'tabNatalidade',
        'routeName' => 'listNatalidade',
        'onClickFunction' => 'selectTabNatalidade()',
    ],
];
@endphp
<script src="{{ asset('js/operationAjax.js')}}"></script>
<script src="{{ asset('utils/mask.js') }}"></script>
<script src="{{ asset('utils/modals.js')}}"></script>
<script src="{{ asset('utils/operationsTable.js')}}"></script>
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
        'columns' => ['Cliente', 'Data Venda', 'Valor Venda', 'Comissao', 'Valor Frete', 'Lucro'],
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


function getActiveTabId() {
  // Seleciona a aba ativa com base na classe 'active' no link dentro do contêiner #tabs
  var activeTabLink = document.querySelector('#customTabs .nav-link.active');
  var id = ""
  // Verifica se encontrou a aba ativa e retorna o ID e a rota correspondente
  if (activeTabLink) {
    id = activeTabLink.id.replace('-tab', '')
    return id ;
  } else {
    return null;
  }
}

function getRouter () {
  var tabActive = getActiveTabId();
  return tabActive === "tabGado" ? "gado" : "natalidade";
}

function getModalContentForNatalidade(mode, data) {
    switch (mode) {
        case "view":
            return `@include('components.modalCreate', [
                "sections" => [
                    [
                        "title" => "Detalhes da Natalidade",
                        "inputs" => [
                            ["name" => "Numeração", "mask" => null],
                            ["name" => "Tipo", "mask" => null],
                            ["name" => "Condicao", "mask" => null],
                            ["name" => "Data Inseminacao", "mask" => "datetime"],
                            ["name" => "Data Gestacao", "mask" => "datetime"]
                        ]
                    ]
                ],
                "mode" => "view",
                "data" => [
                    "Numeracao" => "` + data.numeracao + `",
                    "Tipo" => "` + data.tipo + `",
                    "Condicao" => "` + data.condicao + `",
                    "Data Inseminacao" => "` + data.data_inseminacao + `",
                    "Data Gestacao" => "` + data.data_gestacao + `"
                ]
            ])`;

        case "edit":
            let modalContent = `@include('components.modalCreate', [
                "sections" => [
                    [
                        "title" => "Detalhes da Natalidade",
                        "inputs" => [
                            ["name" => "Numeração", "mask" => null],
                            ["name" => "Tipo", "mask" => null],
                            ["name" => "Condicao", "mask" => null],
                            ["name" => "Data Inseminacao", "mask" => "datetime"],
                            ["name" => "Data Gestacao", "mask" => "datetime"]
                        ]
                    ]
                ],
                "mode" => "edit",
                "data" => [
                    "Numeração" => "` + data.numeracao + `",
                    "Tipo" => "` + data.tipo + `",
                    "Condicao" => "` + data.condicao + `",
                    "Data Inseminacao" => "` + data.data_inseminacao + `",
                    "Data Gestacao" => "` + data.data_gestacao + `"
                ]
            ])`;
            return modalContent.replace('onclick="update()"', 'onclick="update(' + data.id + ')"');

        case "new":
            return `@include('components.modalCreate', [
                "sections" => [
                    [
                        "title" => "Detalhes da Natalidade",
                        "inputs" => [
                            ["name" => "Numeracao Animal", "mask" => null],
                            ["name" => "Tipo Animal", "mask" => null],
                            ["name" => "Gestante", "mask" => null],
                            ["name" => "Data Inseminacao", "mask" => "datetime"],
                            ["name" => "Data Gestacao", "mask" => "datetime"]
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


function getModalContentForGado(mode, data) {
    switch (mode) {
            case "view":
              return `@include('components.modalCreate', [
                "sections" => [
                      [
                          "title" => "Informações do cliente",
                          "inputs" => [
                              ["name" => "Nome", "mask" => null]  // Geralmente não é necessário máscara para nomes
                          ]
                      ],
                      [
                          "title" => "Detalhes da Venda",
                          "inputs" => [
                              ["name" => "Data Venda", "mask" => "datetime"],  // Máscara para data
                              ["name" => "Valor Venda", "mask" => "currency"],  // Máscara para moeda
                              ["name" => "Comissao", "mask" => "currency"],  // Máscara para porcentagem, se aplicável
                              ["name" => "Valor Frete", "mask" => "currency"]  // Máscara para moeda
                          ]
                      ]
                  ],
                  "mode" => "view",
                  "data" => [
                      "Nome" => "` + data.cliente + `",
                      "Data Venda" => "` + data.data_venda + `",
                      "Valor Venda" => "` + data.valor_venda + `",
                      "Comissao" => "` + data.comissao + `",
                      "Valor Frete" => "` + data.valor_frete + `"
                  ]
              ])`;


            case "edit":
              let modalContent = `@include('components.modalCreate', [
                "sections" => [
                      [
                          "title" => "Informações do cliente",
                          "inputs" => [
                              ["name" => "Nome", "mask" => null]  // Geralmente não é necessário máscara para nomes
                          ]
                      ],
                      [
                          "title" => "Detalhes da Venda",
                          "inputs" => [
                              ["name" => "Data Venda", "mask" => "datetime"],  // Máscara para data
                              ["name" => "Valor Venda", "mask" => "currency"],  // Máscara para moeda
                              ["name" => "Comissao", "mask" => "currency"],  // Máscara para porcentagem, se aplicável
                              ["name" => "Valor Frete", "mask" => "currency"]  // Máscara para moeda
                          ]
                      ]
                  ],
                  "mode" => "edit",
                  "data" => [
                      "Nome" => "` + data.cliente + `",
                      "Data Venda" => "` + data.data_venda + `",
                      "Valor Venda" => "` + data.valor_venda + `",
                      "Comissao" => "` + data.comissao + `",
                      "Valor Frete" => "` + data.valor_frete + `"
                  ]
              ])`;
              return modalContent.replace('onclick="update()"', 'onclick="update(' + data.id + ')"');

        case "new":
            return `@include('components.modalCreate', [
              "sections" => [
                    [
                        "title" => "Informações do cliente",
                        "inputs" => [
                            ["name" => "Nome", "mask" => null]  // Geralmente não é necessário máscara para nomes
                        ]
                    ],
                    [
                        "title" => "Detalhes da Venda",
                        "inputs" => [
                            ["name" => "Data Venda", "mask" => "datetime"],  // Máscara para data
                            ["name" => "Valor Venda", "mask" => "currency"],  // Máscara para moeda
                            ["name" => "Comissao", "mask" => "currency"],  // Máscara para porcentagem, se aplicável
                            ["name" => "Valor Frete", "mask" => "currency"]  // Máscara para moeda
                        ]
                    ]
                ],
                "mode" =>  "new",
                "data" => []
            ])`;

        default:
            return "";
    }
}

function getModalContentForMode(mode, data){
  var tabActive = getActiveTabId()
  return tabActive === 'tabGado' ? getModalContentForGado(mode, data) : getModalContentForNatalidade(mode, data);
}

function getModalInputValues() {
    var tabActive = getActiveTabId();
    var data = {}

    if (tabActive === 'tabGado') {
        var cliente = document.getElementById('inputNome').value;
        var date = formatDateToISO(document.getElementById('inputDataVenda').value);
        var venda = unmaskCurrencyValue(document.getElementById('inputValorVenda').value);
        var comissao = unmaskCurrencyValue(document.getElementById('inputComissao').value);
        var frete = unmaskCurrencyValue(document.getElementById('inputValorFrete').value);

        var lucro = parseFloat(venda) - (parseFloat(comissao) + parseFloat(frete));

        data = {
            cliente: cliente,
            data_venda: date,
            valor_venda: venda,
            comissao: comissao,
            valor_frete: frete,
            lucro: lucro
        };
    } else if (tabActive === 'tabNatalidade') {
        var numeracaoAnimal = parseInt(document.getElementById('inputNumeracaoAnimal').value);
        var tipoAnimal = document.getElementById('inputTipoAnimal').value;
        var gestante = false;
        var dataInseminacao = formatDateToISO(document.getElementById('inputDataInseminacao').value);
        var dataGestacao = formatDateToISO(document.getElementById('inputDataGestacao').value);

        data = {
            numeracao_animal: numeracaoAnimal,
            tipo_animal: tipoAnimal,
            gestante: gestante,
            data_inseminacao: dataInseminacao,
            data_gestacao: dataGestacao
        };
    }

    return data;
}


async function create() {
    try {
        const data = getModalInputValues();
        var router = getRouter(); // Certifique-se de que getRouter() está implementado corretamente
        const data_temp = await createItem(router, data); // usando a função createItem
        console.log(data_temp)
        var columnsView;
        if (router === "gado") {
            columnsView = ['Cliente', 'Data Venda', 'Valor Venda', 'Comissao', 'Valor Frete', 'Lucro'];
        } else if (router === "natalidade") {
            columnsView = ['Numeracao Animal', 'Tipo', 'Condicao', 'Data Inseminacao', 'Data Gestacao'];
        }

        // Verifica se o contato foi criado com sucesso antes de tentar adicioná-lo à tabela
        if (data_temp) {
            addRowToActiveTabTable(data_temp, columnsView); // Supondo que a função foi renomeada para corresponder à lógica de aba ativa
            closeModal();

            modalSuccess(router.charAt(0).toUpperCase() + router.slice(1) + " cadastrado com sucesso"); // Torna a primeira letra maiúscula
        } else {
            // Se data_temp for null ou undefined, algo deu errado com a criação do item
            throw new Error(router + " não pôde ser criado. A resposta não contém dados.");
        }
    } catch (error) {
        console.error('Erro ao criar item:', error);
        // Aqui você pode fechar o modal, notificar o usuário, logar o erro, etc.
    }
}


async function visualizarItem(id) {
  try {
    const data = await retrieveItem('gado', id); // usando a função retrieveItem
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
    await updateItem('gado', relatorioId, data); // usando a função updateItem
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
    var router = getRouter(); // Certifique-se de que getRouter() está implementado corretamente
    const data = await retrieveItem(router, id); // usando a função retrieveItem
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

async function deleteData(contactId) {
  try {
    var router = getRouter(); // Certifique-se de que getRouter() está implementado corretamente
    await deleteItem(router, contactId); // usando a função deleteItem
    modalSuccess(router.charAt(0).toUpperCase() + router.slice(1) + " excluido com sucesso"); // Torna a primeira letra maiúscula
    removeRowFromActiveTabTable(contactId)
  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao excluir o cliente');
  }
}


function createDynamicButton() {
  const container = document.createElement('div');
  container.className = 'content-container p-3';

  // Crie o botão
  const button = document.createElement('button');
  button.className = 'btn btn-primary';
  button.dataset.toggle = 'modal';
  button.dataset.target = 'addCliente';
  button.textContent = 'Cadastrar +';
  button.addEventListener('click', () => {
    openModalAction("new");
  });

  // Adicione o botão ao contêiner
  container.appendChild(button);

  tabsFornecedor.prepend(container);
}

function addClickEventToButton(button) {
  button.addEventListener('click', () => {
    openModalAction("new");
  });
}

function loadTabContent(selectedTabButton) {
    const route = selectedTabButton.getAttribute('data-route');
    fetch(route)
      .then(response => response.json())
      .then(data => {
        if (data.tableComponentContent) {
          const tableContainer = document.getElementById('tabs-fon');
          tableContainer.innerHTML = data.tableComponentContent;
          // addCadastrarButton(selectedTabButton.id);
        }
      })
      .catch(error => console.error('Ocorreu um erro:', error));
}

document.addEventListener('DOMContentLoaded', function() {

  const buttonTabClient = document.getElementById('tabGado-tab');
  const buttonTabSupplier = document.getElementById('tabNatalidade-tab');

  function selectTabNatalidade (event){
    const route = event.target.getAttribute('data-route');
    // Realize a solicitação AJAX usando fetch ou jQuery.ajax
    // Exemplo usando fetch:
    loadTabContent(event.target)
    // Esconda o conteúdo da aba Clientes
    document.getElementById('tab1').classList.remove('show', 'active');
    // Mostre o conteúdo da aba Fornecedores
    const tabsFornecedor = document.getElementById('tab2')
    tabsFornecedor.classList.add('show', 'active');
    if (!document.getElementById('btnCadastrarFornecedor')) {
      const container = document.createElement('div');
      container.className = 'content-container p-3';

      // Crie o botão
      const button = document.createElement('button');
      button.className = 'btn btn-primary';
      button.dataset.toggle = 'modal';
      button.dataset.target = 'addCliente';
      button.id = 'btnCadastrarFornecedor';
      button.textContent = 'Cadastrar +';
      addClickEventToButton(button);
      // Adicione o botão ao contêiner
      container.appendChild(button);

      tabsFornecedor.prepend(container)
    }


    buttonTabClient.classList.remove("active")
    buttonTabSupplier.classList.add("active")
  }


  function selectTabGado(event){
    document.getElementById('tab2').classList.remove('show', 'active');
  // Mostre o conteúdo da aba Clientes
    document.getElementById('tab1').classList.add('show', 'active');
    buttonTabSupplier.classList.remove("active")
    buttonTabClient.classList.add("active")
  }

  // Para cada tab, adicione o event listener correspondente
  document.getElementById("tabGado-tab").addEventListener("click", (event) => selectTabGado(event));
  document.getElementById("tabNatalidade-tab").addEventListener("click", (event) => selectTabNatalidade(event));

});

</script>
@endsection