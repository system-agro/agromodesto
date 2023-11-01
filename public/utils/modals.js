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
    setTimeout(function() {
      modalElement.style.display = 'none';
      modalElement.classList.remove('show');
    }, 2000);
  } else {
    console.error('Modal element not found!');
  }
}



function openModalAction(mode = "", data = {}) {
  const container = document.getElementById("tabs");
  const contentModal = createContentModalElement();
  const modalContent = getModalContentForMode(mode, data);

  contentModal.innerHTML += modalContent;
  container.appendChild(contentModal);
  document.getElementById('customModal').style.display = 'block';
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