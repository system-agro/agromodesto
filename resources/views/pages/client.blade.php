@extends('admin::index')

@section('content')
@php
$body_classes = ''; // Defina as classes do corpo conforme necessário
$_user_ = '';
$tabConfig = [
    [
        'title' => 'Clientes',
        'id' => 'tabClient',
        'routeName' => 'testeClient',
        'onClickFunction' => 'selectTabClient()',
        'content' => view('components.table', ['columns' => [
                ["name" => "Nome", "mask" => ""],
                ["name" => "Email", "mask" => ""],
                ["name" => "Telefone", "mask" => "phone"]
            ], 'data' => $contacts, 'columnMapping' => $columnMapping])->render()
    ],
    [
        'title' => 'Fornecedores',
        'id' => 'tabSupplier',
        'routeName' => 'listFornecedor',
        'onClickFunction' => 'selectTabSupplier()'
    ],
];
@endphp
<script src="{{ asset('js/operationAjax.js')}}"></script>
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
        <button class="btn btn-primary btn-cadastrar" data-toggle="modal" data-target="addCliente" id="btnCadastrarCliente">Cadastrar +</button>
      </div>

      <!-- Modal -->

      <!-- Container com fundo branco para a tabela e filtro -->
      <div class="content-container px-3 pb-3" id="containerTable" style="background-color: white;">
        @include('components.table', [
            'columns' => [
                ["name" => "Nome", "mask" => ""],
                ["name" => "Email", "mask" => ""],
                ["name" => "Telefone", "mask" => "phone"]
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

var tabConfig = @json($tabConfig);


function getModalContentForMode(mode, data) {
    switch (mode) {
        case "view":
            return `@include('components.modalCreate', [
              "sections" => [
                  [
                      "title" => "Informações Pessoais",
                      "inputs" => [
                          ["name" => "Nome", "mask" => null],
                          ["name" => "CPF/CNPJ", "mask" => "cpf_cnpj"]  // Aqui você pode especificar uma máscara para CPF ou CNPJ se necessário
                      ]
                  ],
                  [
                      "title" => "Contatos",
                      "inputs" => [
                          ["name" => "Email", "mask" => "email"],
                          ["name" => "Telefone", "mask" => "phone"]  // Aqui você pode especificar uma máscara para telefone se necessário
                      ]
                  ],
                  [
                      "title" => "Endereço",
                      "inputs" => [
                          ["name" => "Estado", "mask" => null],
                          ["name" => "Cidade", "mask" => null],
                          ["name" => "Bairro", "mask" => null]
                      ]
                  ],
                ],
                "mode" =>  "view",
                "data" => [
                    "Nome" => "` + data.name + `",
                    "CPF/CNPJ" => "`+ data.documento +`",
                    "Email" => "` + data.email + `",
                    "Telefone" => "` + data.phone + `",
                    "Estado" => "`+ data.estado + `",
                    "Cidade" => "` + data.cidade + `",
                    "Bairro" => "` + data.bairro +`"
                ]
            ])`;

        case "edit":
            let modalContent = `@include('components.modalCreate', [
              "sections" => [
                  [
                      "title" => "Informações Pessoais",
                      "inputs" => [
                          ["name" => "Nome", "mask" => null],
                          ["name" => "CPF/CNPJ", "mask" => "cpf_cnpj"]  // Aqui você pode especificar uma máscara para CPF ou CNPJ se necessário
                      ]
                  ],
                  [
                      "title" => "Contatos",
                      "inputs" => [
                          ["name" => "Email", "mask" => "email"],
                          ["name" => "Telefone", "mask" => "phone"]  // Aqui você pode especificar uma máscara para telefone se necessário
                      ]
                  ],
                  [
                      "title" => "Endereço",
                      "inputs" => [
                          ["name" => "Estado", "mask" => null],
                          ["name" => "Cidade", "mask" => null],
                          ["name" => "Bairro", "mask" => null]
                      ]
                  ],
                ],
                "mode" =>  "edit",
                "data" => [
                    "Nome" => "` + data.name + `",
                    "CPF/CNPJ" => "`+ data.documento +`",
                    "Email" => "` + data.email + `",
                    "Telefone" => "` + data.phone + `",
                    "Estado" => "`+ data.estado + `",
                    "Cidade" => "` + data.cidade + `",
                    "Bairro" => "` + data.bairro +`"
                ]
            ])`;
            return modalContent.replace('onclick="update()"', 'onclick="update(' + data.id + ')"');

        case "new":
            return `@include('components.modalCreate', [
                "sections" => [
                  [
                      "title" => "Informações Pessoais",
                      "inputs" => [
                          ["name" => "Nome", "mask" => null],
                          ["name" => "CPF/CNPJ", "mask" => "cpf_cnpj"]  // Aqui você pode especificar uma máscara para CPF ou CNPJ se necessário
                      ]
                  ],
                  [
                      "title" => "Contatos",
                      "inputs" => [
                          ["name" => "Email", "mask" => "email"],
                          ["name" => "Telefone", "mask" => "phone"]  // Aqui você pode especificar uma máscara para telefone se necessário
                      ]
                  ],
                  [
                      "title" => "Endereço",
                      "inputs" => [
                          ["name" => "Estado", "mask" => null],
                          ["name" => "Cidade", "mask" => null],
                          ["name" => "Bairro", "mask" => null]
                      ]
                  ],
                ],
                "mode" =>  "new",
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



function addClickEventToButton(button) {
  button.addEventListener('click', () => {
    openModalAction("new", {}, getModalContentForMode);
  });
}

function getModalInputValues() {
    var nome = document.getElementById('inputNome').value;
    var email = unmaskValue(document.getElementById('inputEmail'));
    var telefone = removeSpecialCharacters(document.getElementById('inputTelefone').value);
    var documento = removeSpecialCharacters(document.getElementById('inputCPF/CNPJ').value);
    var estado = document.getElementById('inputEstado').value;
    var cidade = document.getElementById('inputCidade').value;
    var bairro = document.getElementById('inputBairro').value;

    
    const data = {
        name:nome,
        email:email,
        phone:telefone,
        documento:documento,
        estado:estado,
        cidade:cidade,
        bairro:bairro
    };
    console.log(data)

    return data
}




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
  return tabActive === "tabClient" ? "client" : "fornecedor";
}

async function create() {
    try {
        const data = getModalInputValues();
        var router = getRouter(); // Certifique-se de que getRouter() está implementado corretamente
        const data_temp = await createItem(router, data); // usando a função createItem

        var columnsView = router === "client" ?  ['Nome', 'Email', 'Telefone'] : ['Nome', 'Email', 'Telefone', 'Documento', 'Estado', 'Bairro'];

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

window.onEditModal = async function (id) {
  try {
    var router = getRouter(); // Certifique-se de que getRouter() está implementado corretamente
    const data = await retrieveItem(router, id); // usando a função retrieveItem
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

window.deleteData = async function (contactId) {
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

window.visualizarItem = async function (id) {
  try {
    var router = getRouter();
    const data = await retrieveItem(router, id); // usando a função retrieveItem
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

var tableBody = '';
document.addEventListener("DOMContentLoaded", ()=>{
  tableBody = document.querySelector('.table tbody'); 
})


async function update(contactId) {
  try {
    const data = getModalInputValues();
    var router = getRouter(); // Certifique-se de que getRouter() está implementado corretamente
    const response = await updateItem(router, contactId, data); // usando a função updateItem
    closeModal();
    modalSuccess("Cliente atualizado com sucesso");
    console.log(response)
    updateRowInActiveTabTable(response?.data, response?.columnMapping)

  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao atualizar o cliente');
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
    openModalAction("new", {}, getModalContentForMode);
  });

  // Adicione o botão ao contêiner
  container.appendChild(button);

  tabsFornecedor.prepend(container);
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

// Adicione um event listener para a aba Fornecedores



document.addEventListener('DOMContentLoaded', function() {

  const buttonTabClient = document.getElementById('tabClient-tab');
  const buttonTabSupplier = document.getElementById('tabSupplier-tab');

  function selectTabSupplier (event){
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


  function selectTabClient(event){
    document.getElementById('tab2').classList.remove('show', 'active');
  // Mostre o conteúdo da aba Clientes
    document.getElementById('tab1').classList.add('show', 'active');
    buttonTabSupplier.classList.remove("active")
    buttonTabClient.classList.add("active")
  }

  // Para cada tab, adicione o event listener correspondente
  document.getElementById("tabClient-tab").addEventListener("click", (event) => selectTabClient(event));
  document.getElementById("tabSupplier-tab").addEventListener("click", (event) => selectTabSupplier(event));

});
// Adicione um event listener para a aba Clientes

</script>

<script src="{{ asset('utils/eventButtonTable.js')}}"></script>

@endsection