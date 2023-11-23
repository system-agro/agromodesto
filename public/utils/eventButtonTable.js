function onLoadButton() {
  // document.addEventListener('DOMContentLoaded', () => {
  // Adiciona eventos de clique para cada botão de edição
  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', () => {
      const contactId = button.getAttribute('data-contact-id');
      onEditModal(contactId);
    });
  });

  // Adiciona eventos de clique para cada botão de visualização
  document.querySelectorAll('.btn-view').forEach(button => {
    button.addEventListener('click', () => {
      const contactId = button.getAttribute('data-contact-id');
      visualizarItem(contactId);
    });
  });

  // Adiciona eventos de clique para cada botão de exclusão
  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', () => {
      const contactId = button.getAttribute('data-contact-id');
      deleteData(contactId);
    });
  });

  // Adiciona eventos de clique para cada botão de relatório, se existir
  document.querySelectorAll('.btn-relatorio').forEach(button => {
    button.addEventListener('click', () => {
      const contactId = button.getAttribute('data-contact-id');
      downloadPDF(contactId);
    });
  });
  // });
}

onLoadButton()

