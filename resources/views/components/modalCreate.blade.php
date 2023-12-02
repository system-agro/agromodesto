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
  width: 65%; /* Adjust as per requirement */
  font-size: 10px;
  box-sizing: border-box;

  /* Centralize vertically and horizontally */
  position: absolute; /* Use absolute position for positioning */
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
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
          <div class="row p-2">
            <h4>Informações do cliente</h4>
            <div class="col-md-4 ">
              <div class="form-group">
                  <input 
                    type="text" 
                    id="searchClientInput" 
                    class="form-control  form-control-lg rounded" 
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
                      @component('components.input-text-multiple')@endcomponent
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
