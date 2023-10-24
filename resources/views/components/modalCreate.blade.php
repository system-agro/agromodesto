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