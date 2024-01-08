<style>
  .modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1000; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  background-color: rgba(0, 0, 0, 0.6); /* Background with opacity */
  overflow: auto; /* Enable scroll if needed */
}

.modal-content {
  background-color: #fefefe;
  padding: 10px;
  border: 1px solid #888;
  max-height: 100vh; /* Defina um valor máximo adequado para a altura (80% da altura da viewport) */
  height: auto; 
  
  width: 60%; /* Adjust as per requirement */
  font-size: 10px;
  box-sizing: border-box;

  /* Centralize vertically and horizontally */
  position: absolute; /* Use absolute position for positioning */
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  overflow: auto;
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

/* .list-group{
  display:"flex";
  position: absolute;
} */
  .list-group {
    /* position: absolute; */
    background-color: rgba(0, 0, 0, 0.8); /* Cor de fundo escura */
    width: 100%; /* Largura total */
    z-index: 1; /* Garante que a lista de resultados esteja sobreposta a outros elementos */
  }

  .list-group-item {
    color: black; /* Cor do texto branco */
    padding:10px;
    font-size:14px;
    cursor:pointer;
  }

  .form-client {
    margin: 6px 10px;
  }

  select {
    appearance: auto;
  }

  /* Estilo padrão para o elemento select */
  select {
      -webkit-appearance: menulist-button;
      appearance: menulist-button;
  }

  /* .modal-content input {
    width: 150px;
  } */



</style>
@php
$disabled = $mode === 'new' ? '' : 'disabled';
@endphp
<div id="customModal" class="modal">
  <div class="modal-content"> <span class="close justify-content-end" id="closeModal"
      onclick="closeModal()">&times;</span> <!-- Conteúdo do modal -->
    <!-- Seção de Informação Pessoal -->
    @if(is_array($sections) || is_object($sections))
        @if($searchClient === "true")
          <div class="row " >
            <h4>Informações do cliente</h4>
            <div class="col-md-3 form-client ">
              <div class="form-group">
                  <input 
                    type="text" 
                    id="searchClientInput" 
                    class="form-control  form-control-lg rounded"
                    data-client-id = "{{ isset($data['ClienteId']) ? $data['ClienteId'] : '' }}"
                    {{$disabled}} 
                    placeholder="Digite o nome do cliente..." 
                    oninput="searchClient()" 
                    value="{{ isset($data['Cliente']) ? $data['Cliente'] : '' }}"
                  >
              </div>
              <div id="searchResults" class="list-group">
                  <!-- Sugestões de pesquisa serão inseridas aqui -->
              </div>
            </div>
          </div>
        @endif
        @foreach ($sections as $section)
            <div class="row p-2">
                <h4>{{ $section['title'] }}</h4>
                @foreach ($section['inputs'] as $input)
                  @if(isset($input['inputComponent']) && $input['inputComponent'] === "true")
                    <div class="col-md-12">
                      @component('components.input-text-multiple', 
                        [
                          'data' => isset($data['Compra Madeira']) ? $data['Compra Madeira'] : '' 
                        ])
                      @endcomponent
                    </div> 
                  @else
                    <div class="col-md-3">

                        {{-- 'mask' is fetched from the input array, so it's available here --}}
                        @include('components.input-fileds', [
                            'input' => $input,
                            'mode' => $mode,
                            'data' => $data[$input['name']] ?? '',
                            'mask' => $input['mask'] ?? '',
                        ])
                    </div>
                  @endif
                @endforeach
                
            </div>
        @endforeach
        @include('components.input-type-payment')
    @endif
    <!-- Seção de Contato -->
    @if ($mode !== 'view')
    <div class="row justify-content-end p-3">
      <div class="col-md-2">
        @if ($mode === 'edit')
        <button id="btnSalvar" class="btn btn-primary" style="width:100%" onclick="update()">Atualizar</button>
        @else
        <button id="btnSalvar" class="btn btn-primary" style="width:100%"
          onclick="create()">Salvar</button>
        @endif
      </div>
    </div>
    @endif
  </div>
</div>

<!-- <script src="{{ asset('js/searchClient.js')}}"></script>; -->
