@props(['title'])

<style>
  /* Personalize o modal */
  #successModal .modal-content {
    border-radius: 20px;
    display: "flex";
    width: 100%;
    /* Adicione bordas arredondadas */
  }

  #successModal .modal-body {
    text-align: center;
    /* Centralize o texto */
  }

  .modal-body {
    display: "flex";
  }

  /* Esconda o botão de fechar */
  #successModal .modal-header .close {
    display: none;
  }

  .check-icon {
    width: 32px;
    height: 32px;
    background-color: #4CAF50;
    /* Cor de fundo verde (pode ser personalizada) */
    border-radius: 50%;
    /* Forma circular */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    /* Tamanho do ícone */
    color: #fff;
    /* Cor do ícone (pode ser personalizada) */
  }
</style>


<!-- Modal de Sucesso -->
<div id="successModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="modal-title">{{$title}}</h4>
          </div>
          <div class="col-3 text-center">
            <div class="check-icon">
              <span>&#10003;</span> <!-- Código do caractere Unicode para um checkmark (✔) -->
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>