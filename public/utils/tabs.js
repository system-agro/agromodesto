function selectTab(event, tabContentId) {
  const clickedTab = event.currentTarget;
  const route = clickedTab.getAttribute('data-route');
  const targetPane = document.getElementById(tabContentId);

  fetch(route)
      .then(response => response.json())
      .then(data => {
          targetPane.innerHTML = data.content; // Aqui, considere que "content" é uma propriedade do JSON recebido.
      })
      .catch(error => {
          console.error('Ocorreu um erro:', error);
      });
  
  // Esconde todas as abas
  document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('show', 'active'));
  // Mostra a aba clicada
  targetPane.classList.add('show', 'active');

  // Desativa todos os links das abas
  document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
  // Ativa o link da aba clicada
  clickedTab.classList.add('active');
}

function selectTabClient() {
  const clientTab = document.getElementById('tabClient-tab');
  selectTab({currentTarget: clientTab}, 'tabClient');
}

function selectTabSupplier() {
  const supplierTab = document.getElementById('tabSupplier-tab');
  selectTab({currentTarget: supplierTab}, 'tabSupplier');
}
