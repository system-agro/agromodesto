function modalSuccess(message) {
  Swal.fire({
      title: 'Sucesso!',
      text: message,
      icon: 'success',
      timer: 2000,
      showConfirmButton: false
  });
}

async function confirmDeleteModal() {
  return new Promise((resolve) => {
      Swal.fire({
          title: 'Confirmar Exclusão',
          text: 'Tem certeza que deseja excluir este item?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sim, excluir!'
      }).then((result) => {
          resolve(result.isConfirmed);
      });
  });
}

function formatDateToBR(dateTimeString) {
  // Separa a data e a hora
  const [datePart] = dateTimeString.split(' '); // Isso descarta o tempo
  // Extrai os componentes da data
  const [year, month, day] = datePart.split('-');
  // Retorna a data no formato dd/mm/yyyy
  return `${day}/${month}/${year}`;
}


function applyInputMasks() {
  const masks = document.querySelectorAll('input[data-mask]');
  masks.forEach(input => {
    const mask = input.getAttribute('data-mask');
    // Verifique se a máscara é 'currency' e aplique a configuração de moeda
    if (mask === 'currency') {
      Inputmask('currency', {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: 'R$ ',
        rightAlign: false, // Normalmente para inputs de moeda não se alinha a direita
        unmaskAsNumber: true,
        removeMaskOnSubmit: true,
        // Adiciona a opção clearMaskOnLostFocus se você não quiser que o usuário veja zeros quando o input não estiver focado
        clearMaskOnLostFocus: false
      }).mask(input);
    } else if (mask === 'datetime') {
      const currentValue = input.value;
      input.value = formatDateToBR(currentValue);
      Inputmask("datetime", {
        inputFormat: "dd/mm/yyyy",
        outputFormat: "dd/mm/yyyy",
        // outras configurações conforme necessário
      }).mask(input);
    } else if (mask === 'cpf_cnpj') {
      Inputmask({
        mask: ['999.999.999-99', '99.999.999/9999-99'],
        keepStatic: true, // Mantém a máscara estática enquanto é possível
        // outras configurações conforme necessário
      }).mask(input);
    } else if (mask === "phone") {
      Inputmask({
        mask: ['(99)9999-9999', '(99)99999-9999'],
        keepStatic: true, // Mantém a máscara estática enquanto é possível
        // outras configurações conforme necessário
      }).mask(input);
    } else {
      // Se não for 'currency', aplica a máscara genérica
      Inputmask(mask).mask(input);
    }
  });
}


function adicionarConjunto() {
  // Encontra o containerForm original
  const containerForm = document.querySelector('.containerForm');
  const elemntOriginal = containerForm.lastElementChild;
  const buttonChild = elemntOriginal.lastElementChild;
  elemntOriginal.removeChild(buttonChild)
  const elementAdd = containerForm.lastElementChild.cloneNode(true);

  const inputs = elementAdd.querySelectorAll('input');
  inputs.forEach(input => input.value = ''); // Limpa cada input



  // var containerOriginal = document.querySelector('.containerForm');
  containerForm.appendChild(elementAdd);
  containerForm.lastElementChild.appendChild(buttonChild)

  applyInputMasks()



}


function adicionarConjuntosComprasMadeira(comprasMadeira, mode = "") {
  // Encontra o containerForm original
  const containerForm = document.querySelector('.containerForm');
  const elementOriginal = containerForm.firstElementChild;

  if (containerForm.children.length > 0) {
    console.log(containerForm.children.length);

    // Remove o último filho
    containerForm.removeChild(containerForm.firstElementChild);
  } else {
    console.log('O container está vazio. Nenhum elemento foi removido.');
  }

  // Obtém o modelo de input original
  const buttonChild = elementOriginal.lastElementChild;
  elementOriginal.removeChild(buttonChild);

  // Para cada compra_madeira, adiciona um novo conjunto de inputs
  comprasMadeira.forEach(compra => {
    const elementAdd = elementOriginal.cloneNode(true);
    const inputs = elementAdd.querySelectorAll('input');

    // Preenche os inputs com os dados da compra e desabilita se o mode for "view"
    inputs.forEach(input => {
      const inputName = input.getAttribute('name');
      if (compra.hasOwnProperty(inputName)) {
        input.value = compra[inputName];
        if (mode === 'view') {
          input.disabled = true;
        }
      } else {
        input.value = ''; // Limpa os demais inputs
      }
    });

    // Adiciona o novo conjunto ao containerForm
    containerForm.appendChild(elementAdd);

    // Adiciona o botão apenas se o mode não for "view"
    if (mode !== 'view') {
      containerForm.lastElementChild.appendChild(buttonChild);
    }
  });

  // Adiciona o botão no final apenas se o mode não for "view"
  if (mode !== 'view') {
    containerForm.lastElementChild.appendChild(buttonChild);
  }

  applyInputMasks();
}






function addEventButtonForm() {
  if (!document.getElementById('addInput')) return;
  // document.addEventListener("DOMContentLoaded", () => {
  document.getElementById('addInput').onclick = adicionarConjunto;
  // })
}


function openModalAction(mode = "", data = {}, body = () => { }) {
  const container = document.getElementById("tabs");
  const contentModal = createContentModalElement();
  const modalContent = body(mode, data);

  contentModal.innerHTML += modalContent;
  container.appendChild(contentModal);
  document.getElementById('customModal').style.display = 'block';

  addEventButtonForm();
  applyInputMasks();
}

function createContentModalElement() {
  const contentModal = document.createElement('div');
  contentModal.className = 'container';
  contentModal.id = 'contentModal';
  return contentModal;
}

function closeModal() {
  var element = document.getElementById('customModal');
  if (element) {
    element.parentNode.removeChild(element);
  }
}