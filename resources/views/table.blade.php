@extends('admin::index')

@section('content')
@php
$body_classes = ''; // Defina as classes do corpo conforme necessário
$_user_ = '';
@endphp

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
</style>

<div id="tabs">
  <ul class="nav nav-tabs" id="customTabs" role="tablist">
    <!-- Aba de Clientes -->
    <li class="nav-item">
      <a aria-selected="true" class="nav-link active" id="tab1-tab" data-toggle="tab" role="tab" aria-controls="tab1"
        data-route="{{ route('testeClient') }}" onclick="selectTabClient()">Clientes</a>
    </li>
    <!-- Aba de Fornecedores -->
    <li class="nav-item">
      <a class="nav-link" id="tab2-tab" data-toggle="tab" role="tab" aria-controls="tab2" aria-selected="false"
        data-route="{{ route('listFornecedor') }}" onclick="selectTabSupplier()">Fornecedores</a>
    </li>
  </ul>
  

  <!-- Conteúdo das abas -->
  <div class="tab-content" id="customTabsContent">
    <!-- Conteúdo para a aba de Clientes -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
      <!-- Botão "Cadastrar +" -->
      <div id="container-button-cadastrar" class="content-container p-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="addCliente" id="btnCadastrarCliente" onclick="openModal('edit')">Cadastrar
          +</button>
      </div>

      <!-- Modal -->

      <!-- Container com fundo branco para a tabela e filtro -->
      <div class="content-container px-3 pb-3" style="background-color: white;">
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
function openModal(mode, data = {}) {
    
    const container = document.getElementById("tabs")
    const contentModal = document.createElement('div');
    contentModal.className = 'container';
    contentModal.id = 'contentModal';
    var modalContent = "";
    var temp_mode = mode;
    const temp_data =  {
      "Nome": data.name,
      "Email": data.email,
      "Telefone": data.phone
    }

    if(temp_mode === "view"){
        modalContent = `@include('components.modalCreate', [
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
              "Nome" => "`+data.name+`",
              "Email" => "`+data.email+`",
              "Telefone" => "`+data.phone+`"
            ]

        ])`;
    }else{
        modalContent = `@include('components.modalCreate', [
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
            "data" => []
        ])`;
    }
    contentModal.innerHTML += modalContent
    container.appendChild(contentModal)
    document.getElementById('customModal').style.display = 'block';
    temp_mode = "";
}

function closeModal() {
    var element = document.getElementById('customModal');
  if (element) {
    element.parentNode.removeChild(element);
  }
}

async function visualizarItem(id) {
  try {
    const response = await fetch(`detail/${id}`);
    if (response.ok) {
      const data = await response.json();
      // Manipulate the API data here
      console.log(data)
      openModal('view', data)
        
    } else {
      console.error('Error calling the API:', response.status);
    }
  } catch (error) {
    console.error('An error occurred:', error);
  }
}

const buttonTabClient = document.getElementById('tab1-tab');
const buttonTabSupplier = document.getElementById('tab2-tab');

function addClickEventToButton(button) {
  button.addEventListener('click', () => {
    openModal("edit");
  });
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
    openModal("edit");
  });

  // Adicione o botão ao contêiner
  container.appendChild(button);

  tabsFornecedor.prepend(container);
}

function selectTabSupplier (){

    var route = buttonTabSupplier.getAttribute('data-route');
    console.log("teset")
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
// Adicione um event listener para a aba Fornecedores

function selectTabClient(){
    document.getElementById('tab2').classList.remove('show', 'active');
  // Mostre o conteúdo da aba Clientes
    document.getElementById('tab1').classList.add('show', 'active');
    buttonTabSupplier.classList.remove("active")
    buttonTabClient.classList.add("active")
}
// Adicione um event listener para a aba Clientes

</script>
@endsection