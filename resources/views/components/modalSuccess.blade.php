@props(['title'])

<style>

  #successModal {
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
  /* Personalize o modal */

  #successModal .modal-content {
    background-color: #fefefe;
    padding: 10px;
    border: 1px solid #888;
    max-height: 100vh; /* Defina um valor máximo adequado para a altura (80% da altura da viewport) */
    height: auto; 
    
    width: 20%; /* Adjust as per requirement */
    font-size: 10px;
    box-sizing: border-box;

    /* Centralize vertically and horizontally */
    position: absolute; /* Use absolute position for positioning */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    overflow: auto;
    border-radius: 20px;
    display: "flex";
    /* width: 100%; */
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
<div id="successModal" class="modal">
  <!-- <div class="modal-dialog"> -->
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

    <!-- </div> -->
  </div>
</div>