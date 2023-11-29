function formatReal(value) {
  // Garante que o valor é um número decimal com dois dígitos após a vírgula
  value = Number(value).toFixed(2);

  // Formata o valor como moeda
  return value
    .replace('.', ',') // Substitui o ponto decimal por vírgula
    .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Adiciona ponto como separador de milhares
}

function maskCpfCnpj(value) {
  // Remove caracteres não numéricos
  value = value.replace(/\D/g, "");

  // Verifica o comprimento para determinar se é CPF ou CNPJ
  if (value.length <= 11) {
      // Máscara de CPF
      return value
          .replace(/(\d{3})(\d)/, "$1.$2")
          .replace(/(\d{3})(\d)/, "$1.$2")
          .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
  } else {
      // Máscara de CNPJ
      return value
          .replace(/^(\d{2})(\d)/, "$1.$2")
          .replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
          .replace(/\.(\d{3})(\d)/, ".$1/$2")
          .replace(/(\d{4})(\d)/, "$1-$2");
  }
}


function maskDate(value) {
  return value.replace(/\D/g, "")
    .replace(/(\d{2})(\d)/, "$1/$2")
    .replace(/(\d{2})(\d{1,2})$/, "$1/$2")
    .replace(/(\/\d{2})\d+?$/, "$1");
}

function formatDateToBR(dateTimeString) {
  // Separa a data e a hora
  // const [datePart] = dateTimeString.split(' '); // Isso descarta o tempo
  // Extrai os componentes da data
  const [year, month, day] = dateTimeString.split('-');
  // Retorna a data no formato dd/mm/yyyy
  return `${day}/${month}/${year}`;
}

function maskPhone(value) {
  console.log(value)
  // Remove todos os caracteres não numéricos
  value = value.replace(/\D/g, "");

  // Aplica a máscara com base no comprimento do número
  if (value.length <= 10) {
    // Formato (99)9999-9999
    value = value.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1)$2-$3");
  } else {
    // Formato (99)99999-9999
    value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1)$2-$3");
  }

  return value;
}


function applyMasksToTable(rowOrId = null) {
  let cells;

  // Se um ID de linha específico for fornecido, selecione a linha com base nesse ID
  if (typeof rowOrId === 'string' || typeof rowOrId === 'number') {
    const row = document.querySelector(`tr[data-id="${rowOrId}"]`);
    if (!row) {
      console.error('Linha não encontrada para o contato com ID:', rowOrId);
      return;
    }
    cells = row.querySelectorAll('td[data-mask]');
  }
  // Se uma linha específica (elemento tr) for fornecida, use-a diretamente
  else if (rowOrId instanceof Element) {
    cells = rowOrId.querySelectorAll('td[data-mask]');
  }
  // Caso contrário, selecione todas as células que precisam de máscaras na tabela
  else {
    cells = document.querySelectorAll('td[data-mask]');
  }

  cells.forEach(cell => {
    const maskType = cell.getAttribute('data-mask');
    let value = cell.textContent;

    // Aplica a máscara com base no tipo especificado
    switch (maskType) {
      case 'currency':
        cell.textContent = `R$ ${formatReal(value)}`;
        break;
      case 'cpf_cnpj':
        cell.textContent = maskCpfCnpj(value);
        break;
      case 'date':
        cell.textContent = formatDateToBR(value);
        break;
      case 'phone':
        cell.textContent = maskPhone(value);
        break;
      // Adicione mais casos conforme necessário
    }
  });
}


applyMasksToTable()


