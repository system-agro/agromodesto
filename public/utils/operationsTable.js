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

function removeRowFromActiveTabTable(contactId) {
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

  // Encontre a linha (tr) com o data-id correspondente ao id do contato
  var rowToRemove = tableBody.querySelector(`tr[data-id="${contactId}"]`);
  if (rowToRemove) {
    tableBody.removeChild(rowToRemove);
  } else {
    console.error('Não foi possível encontrar a linha para remover.');
  }
}

function updateRowInActiveTabTable(updatedData, columnMapping) {
  var activeTabPane = document.querySelector('.tab-pane.active');
  if (!activeTabPane) {
    console.error('Não foi possível encontrar uma aba ativa.');
    return;
  }

  var tableBody = activeTabPane.querySelector('.table tbody');
  if (!tableBody) {
    console.error('Não foi possível encontrar o corpo da tabela na aba ativa.');
    return;
  }

  console.log(updatedData)
  var rowToUpdate = tableBody.querySelector(`tr[data-id="${updatedData.id}"]`);
  if (!rowToUpdate) {
    console.error('Não foi possível encontrar a linha para atualizar.');
    return;
  }

  // Obtem todas as células (td) da linha que estão associadas a uma coluna
  var cellsToUpdate = rowToUpdate.querySelectorAll('td[data-column]');
  
  cellsToUpdate.forEach(function(cell) {
    var columnName = cell.getAttribute('data-column');
    var property = columnMapping[columnName];
    if (property && updatedData.hasOwnProperty(property)) {
      cell.textContent = updatedData[property];
    } else {
      console.error(`Não foi possível encontrar a propriedade para a coluna: ${columnName}`);
    }
  });
}



