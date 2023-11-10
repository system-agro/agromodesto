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

</style>

<div id="customModal" class="modal">
  <div class="modal-content"> <span class="close justify-content-end" id="closeModal"
      onclick="closeModal()">&times;</span> <!-- Conteúdo do modal -->
    <!-- Seção de Informação Pessoal -->
    @if(is_array($sections) || is_object($sections))
        @foreach ($sections as $section)
            <div class="row p-2">
                <h4>{{ $section['title'] }}</h4>
                @foreach ($section['inputs'] as $input)
                <div class="col-md-3">
                    {{-- 'mask' is fetched from the input array, so it's available here --}}
                    @include('components.input-fileds', [
                        'input' => $input,
                        'mode' => $mode,
                        'data' => $data[$input['name']] ?? '',
                        'mask' => $input['mask'] ?? ''
                    ])
                </div>
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