

function modalSuccess(title) {
  const modalElement = document.getElementById('successModal');

  if (modalElement) {
    // Atualize o título ou qualquer outro conteúdo conforme necessário
    const titleElement = modalElement.querySelector('.modal-title'); // ajuste o seletor conforme necessário
    if (titleElement) {
      titleElement.textContent = title;
    }

    // Exiba o modal
    modalElement.style.display = 'block';
    modalElement.classList.add('show');

    // Esconda o modal depois de algum tempo
    setTimeout(function () {
      modalElement.style.display = 'none';
      modalElement.classList.remove('show');
    }, 2000);
  } else {
    console.error('Modal element not found!');
  }
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