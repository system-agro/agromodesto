<div id="customModal" class="modal"> <div class="modal-content"> <span class="close justify-content-end"
  id="closeModal">&times;</span>
  <!-- Conteúdo do modal -->
    <!-- Seção de Informação Pessoal -->
    @foreach ($sections as $section)
      <div class="row p-3">
        <h2>{{ $section['title'] }}</h2>
        @foreach ($section['inputs'] as $input)
          <div class="col-md-6">
            <label for="rua">{{$input}}:</label>
            <input type="text" id="{{$input}}" name="{{$input}}" class="form-control form-control-lg rounded">
          </div>
        @endforeach
      </div>
    @endforeach
    <!-- Seção de Contato -->

  <div class="row justify-content-end p-3">
    <div class="col-md-2">
      <button id="btnSalvar" class="btn btn-primary" style="width:100%">Salvar</button>
    </div>
  </div>
</div>
</div>