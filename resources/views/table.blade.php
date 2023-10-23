@extends('admin::index')

@section('content')
@php
    $body_classes = ''; // Defina as classes do corpo conforme necessário
    $_user_ = '';
    // $contacts = json_encode($contacts);
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
                data-route="{{ route('testeClient') }}">Clientes</a>
        </li>
        <!-- Aba de Fornecedores -->
        <li class="nav-item">
            <a class="nav-link" id="tab2-tab" data-toggle="tab" role="tab" aria-controls="tab2"
                aria-selected="false">Fornecedores</a>
        </li>
    </ul>

    <!-- Conteúdo das abas -->
    <div class="tab-content" id="customTabsContent">
        <!-- Conteúdo para a aba de Clientes -->
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- Botão "Cadastrar +" -->
            <div class="content-container p-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#cadastroModal" id="btnCadastrar">Cadastrar
                    +</button>
            </div>

            <!-- Modal -->
            <div id="customModal" class="modal">
                <div class="modal-content">
                    <span class="close justify-content-end" id="closeModal">&times;</span>
                    <!-- Conteúdo do modal -->
                    <!-- Seção de Informação Pessoal -->
                    <div class="row p-3">
                        <h2>Informação Pessoal</h2>

                        <div class="col-md-6">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" class="form-control form-control-lg rounded">
                        </div>
                        <div class="col-md-6">
                            <label for="sobrenome">Sobrenome:</label>
                            <input type="text" id="sobrenome" name="sobrenome" class="form-control form-control-lg rounded">
                        </div>
                    </div>

                    <!-- Seção de Contato -->
                    <div class="row p-3">
                        <h2>Contato</h2>

                        <div class="col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg rounded">
                        </div>
                        <div class="col-md-6">
                            <label for="telefone">Telefone:</label>
                            <input type="tel" id="telefone" name="telefone" class="form-control form-control-lg rounded">
                        </div>
                    </div>

                    <!-- Seção de Endereço -->
                    <div class="row p-3">
                        <h2>Endereço</h2>
                        <div class="col-md-6">
                            <label for="rua">Rua:</label>
                            <input type="text" id="rua" name="rua" class="form-control form-control-lg rounded">
                        </div>
                        <div class="col-md-6">
                            <label for="numero">Número:</label>
                            <input type="text" id="numero" name="numero" class="form-control form-control-lg rounded">
                        </div>
                    </div>

                    <div class="row justify-content-end p-3">
                        <div class="col-md-2">
                            <button id="btnSalvar" class="btn btn-primary" style="width:100%">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container com fundo branco para a tabela e filtro -->
            <div class="content-container px-3 pb-3" style="background-color: white;">
                <!-- <table id="contacts-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> -->
                <!-- Adicione aqui os filtros ou qualquer outro conteúdo que desejar -->
                @include('components.table', [
                'columns' => ['Nome', 'Email', 'Telefone'],
                'data' => $contacts,
                'columnMapping' => $columnMapping
                ])
            </div>
        </div>

        <!-- Conteúdo para a aba de Fornecedores -->
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <!-- Conteúdo para a aba de Fornecedores aqui -->
            <div class="content-container px-3 pb-3" style="background-color: white;">
                <table id="contacts-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <!-- <td>{{ $contact->phone }}</td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Adicione aqui os filtros ou qualquer outro conteúdo que desejar -->
            </div>
        </div>
    </div>
</div>
<!-- Seu código HTML aqui, incluindo o botão "Cadastrar +" e o modal -->
<script>
    // Função para abrir o modal
    function openModal() {
        document.getElementById('customModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('customModal').style.display = 'none';
    }

    // Adicionando um event listener ao botão
    document.getElementById('btnCadastrar').addEventListener('click', openModal);
    document.getElementById('closeModal').addEventListener('click', closeModal);

    const buttonTabClient = document.getElementById('tab1-tab');
    const buttonTabSupplier = document.getElementById('tab2-tab');
    // Adicione um event listener para a aba Fornecedores
    buttonTabSupplier.addEventListener('click', function () {
        // Esconda o conteúdo da aba Clientes
        document.getElementById('tab1').classList.remove('show', 'active');
        // Mostre o conteúdo da aba Fornecedores
        document.getElementById('tab2').classList.add('show', 'active');
        buttonTabClient.classList.remove("active")
        buttonTabSupplier.classList.add("active")
    });

    // Adicione um event listener para a aba Clientes
    buttonTabClient.addEventListener('click', function () {
        // Esconda o conteúdo da aba Fornecedores
        document.getElementById('tab2').classList.remove('show', 'active');
        // Mostre o conteúdo da aba Clientes
        document.getElementById('tab1').classList.add('show', 'active');
        buttonTabSupplier.classList.remove("active")
        buttonTabClient.classList.add("active")
    });
</script>
@endsection
