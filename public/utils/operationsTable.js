function addRowToActiveTabTable(data, columns, columnMapping) {
  // Primeiro, encontre a aba ativa
  var activeTabPane = document.querySelector('.tab-pane.active');
  if (!activeTabPane) {
    console.error('Não foi possível encontrar uma aba ativa.');
    return;
  }

  // Dentro da aba ativa, encontre o corpo da tabela
  var tableBody = activeTabPane.querySelector('.table tbody');
  if (!tableBody) {
    console.error('Não foi possível encontrar o corpo da tabela na aba ativa.');
    return;
  }

  var contact = data.response;
  var columnMapping = data.columnMapping;

  // Crie a nova linha da tabela
  var row = document.createElement('tr');
  row.setAttribute('data-id', contact.id);

  // Adicione as células (td) para cada coluna desejada
  columns.forEach(function(column) {
    var td = document.createElement('td');
    // O columnMapping mapeia o título da coluna para a chave do objeto contact
    td.textContent = contact[columnMapping[column]];
    row.appendChild(td);
  });

  // Adicione as células para as ações
  var actionsTd = document.createElement('td');
  actionsTd.className = 'col-1';
  // Atualize os IDs e os manipuladores de eventos conforme necessário
  actionsTd.innerHTML = `
    <button class="btn btn-primary" onclick="onEditModal(${contact.id})">Editar</button>
    <button class="btn btn-success" onclick="visualizarItem(${contact.id})">Visualizar</button>
    <button class="btn btn-danger" onclick="deleteData(${contact.id})">Excluir</button>
    <button class="btn btn-light" onclick="downloadPDF(${contact.id})">Relatorio</button>
  `;

  row.appendChild(actionsTd);

  // Adicione a nova linha ao corpo da tabela na aba ativa
  tableBody.appendChild(row);
}
