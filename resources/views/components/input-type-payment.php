

<style>
  input[type="number"] {
  -moz-appearance: 'textfield';
  }
</style>
<div id="containerTypePayment" class="row containerTypePayment" style="display: none;">
    <div class="row p-3 m-1">
        <div class="col-md-2">
          <label for="tipo_pagamento">Tipo de Pagamento:</label>
          <select id="tipo_pagamento" name="tipo_pagamento" class="form-control form-control-lg rounded">
            <option value="dinheiro">Dinheiro</option>
            <option value="cheque">Cheque</option>
            <option value="cheque_parcelado">Cheque Parcelado</option>
          </select>
        </div>
        <div id="parcelas_container" style="display: none;" class="col-md-2">
          <label for="quantidade_parcelas">Quantidade de Parcelas:</label>
          <input type="number" name="quantidade_parcelas" id="quantidade_parcelas" class="form-control form-control-lg rounded" min="1" value="1" step="1">
        </div>
    </div>
</div>
