<div id="customModal" class="modal">
  <div class="modal-content"> <span class="close justify-content-end" id="closeModal" onclick="closeModal()">&times;</span>
    <!-- Conteúdo do modal -->
    <!-- Seção de Informação Pessoal -->
    @foreach ($sections as $section)
    <div class="row p-3">
      <h2>{{ $section['title'] }}</h2>
      @foreach ($section['inputs'] as $input)
      <div class="col-md-6">
        @include('components.input-fileds', ['input' => $input, 'mode' => $mode, 'data' => $data])
      </div>
      @endforeach
    </div>
    @endforeach
    <!-- Seção de Contato -->
    @if ($mode !== 'view')
    <div class="row justify-content-end p-3">
      <div class="col-md-2">
        <button id="btnSalvar" class="btn btn-primary" style="width:100%" onclick="getModalInputValues()">Salvar</button>
      </div>
    </div>
    @endif
  </div>
</div>