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
        'content' => view('components.table', ['columns' => ['Nome', 'Email', 'Telefone'], 'data' => $contacts, 'columnMapping' => $columnMapping])->render()
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
        'columns' => ['Nome', 'Email', 'Telefone'],
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

const tabsConfig = {
    tabClient: {
        label: "Clientes",
        route: "{{ route('testeClient') }}",
        tabId: "tab1-tab",
        ariaControls: "tab1"
    },
    tabSupplier: {
        label: "Fornecedores",
        route: "{{ route('listFornecedor') }}",
        tabId: "tab2-tab",
        ariaControls: "tab2"
    }
    // ... Você pode adicionar mais abas conforme necessário.
};


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
            return modalContent.replace('onclick="update()"', 'onclick="update(' + data.id + ')"');

        case "new":
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
                "mode" =>  "new",
                "data" => []
            ])`;

        default:
            return "";
    }
}

async function visualizarItem(id) {
  try {
    const data = await retrieveItem('client', id); // usando a função retrieveItem
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

async function onEditModal(id) {
  try {
    const data = await retrieveItem('client', id); // usando a função retrieveItem
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




function addClickEventToButton(button) {
  button.addEventListener('click', () => {
    openModalAction("new");
  });
}

function getModalInputValues() {
    var nome = document.getElementById('inputNome').value;
    var email = document.getElementById('inputEmail').value;
    var telefone = document.getElementById('inputTelefone').value;
    
    const data = {
        name:nome,
        email:email,
        phone:telefone
    };

    return data
}

async function deleteClient(clientId) {
  try {
    await deleteItem('client', clientId); // usando a função deleteItem

    modalSuccess("Cliente excluido com sucesso");
    setTimeout(function() {
        location.reload();
    }, 1000);

  } catch (error) {
    console.error('An error occurred:', error);
    alert('Ocorreu um erro ao excluir o cliente');
  }
}

async function create() {
  try {
    const data = getModalInputValues();
    await createItem('client', data); // usando a função createItem
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

async function update(clientId) {
  try {
    const data = getModalInputValues();
    await updateItem('client', clientId, data); // usando a função updateItem

    closeModal();
    modalSuccess("Cliente atualizado com sucesso");
    setTimeout(function() {
        location.reload();
    }, 1000);
    // Refresh the form or the table as needed

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
    openModalAction("new");
  });

  // Adicione o botão ao contêiner
  container.appendChild(button);

  tabsFornecedor.prepend(container);
}


// Adicione um event listener para a aba Fornecedores



document.addEventListener('DOMContentLoaded', function() {

  const buttonTabClient = document.getElementById('tabClient-tab');
  const buttonTabSupplier = document.getElementById('tabSupplier-tab');

  function selectTabSupplier (event){
    const route = event.target.getAttribute('data-route');
    // Realize a solicitação AJAX usando fetch ou jQuery.ajax
    // Exemplo usando fetch:
    fetch(route)
      .then(response => response.json())
      .then(data => {
        // Atualize a tabela com os novos dados (data)
        if (data.tableComponentContent) {
          const tableContainer = document.getElementById('tabs-fon');
          tableContainer.innerHTML = data.tableComponentContent;
        }
      })
      .catch(error => {
        console.error('Ocorreu um erro:', error);
      });
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
@endsection