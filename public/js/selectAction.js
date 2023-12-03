// Função para lidar com a lógica de pagamento
function actionTypePayment() {
  if (!document.getElementById('customModal')) {
    console.log("Modal não encontrado");
    return;
  } else {
    
    document.getElementById('tipo_pagamento').addEventListener('change', function (e) {
      var tipoPagamento = e.target.value;
      var parcelasContainer = document.getElementById('parcelas_container');
      console.log(tipoPagamento)
      // Exibir o campo de quantidade de parcelas apenas se for selecionado "Cheque Parcelado"
      if (tipoPagamento === 'cheque_parcelado') {
        parcelasContainer.style.display = 'block';
      } else {
        parcelasContainer.style.display = 'none';
      }
    });
  }
}

// Chame a função quando o código for inicializado ou em algum ponto apropriado
actionTypePayment();
