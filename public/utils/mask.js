// function maskCurrency(value) {
//   return value.replace(/\D/g, "") // Permite apenas dígitos, substituindo todos os caracteres não-dígitos
//     .replace(/(\d)(\d{2})$/, "$1,$2") // Coloca a vírgula antes dos últimos 2 dígitos
//     .replace(/(?=(\d{3})+(\D))\B/g, "."); // Adiciona o ponto a cada 3 dígitos
// }

function maskCPF(value) {
  return value.replace(/\D/g, "")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    .replace(/(-\d{2})\d+?$/, "$1");
}

function maskCNPJ(value) {
  return value.replace(/\D/g, "")
    .replace(/^(\d{2})(\d)/, "$1.$2")
    .replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
    .replace(/\.(\d{3})(\d)/, ".$1/$2")
    .replace(/(\d{4})(\d)/, "$1-$2")
    .replace(/(-\d{2})\d+?$/, "$1");
}

function maskDate(value) {
  return value.replace(/\D/g, "")
    .replace(/(\d{2})(\d)/, "$1/$2")
    .replace(/(\d{2})(\d{1,2})$/, "$1/$2")
    .replace(/(\/\d{2})\d+?$/, "$1");
}

function formatDateToBR(dateTimeString) {
  // Separa a data e a hora
  const [datePart] = dateTimeString.split(' '); // Isso descarta o tempo
  // Extrai os componentes da data
  const [year, month, day] = datePart.split('-');
  // Retorna a data no formato dd/mm/yyyy
  return `${day}/${month}/${year}`;
}



// Exemplo de função que será chamada no evento onkeyup do input
function onKeyUpCurrency(event) {
  event.target.value = maskCurrency(event.target.value);
}

function onKeyUpCPF(event) {
  event.target.value = maskCPF(event.target.value);
}

function onKeyUpCNPJ(event) {
  event.target.value = maskCNPJ(event.target.value);
}

function onKeyUpDate(event) {
  event.target.value = maskDate(event.target.value);
}

function unmaskAndCollectData() {
  const masks = document.querySelectorAll('input[data-mask]');
  const formData = {};

  masks.forEach(input => {
    Inputmask.remove(input); // Remove a máscara do input
    formData[input.name] = input.value; // Coleta o valor sem máscara
  });

  // Aqui você teria seu objeto formData com todos os valores sem máscaras
  // e poderia proceder com o envio dos dados (payload)

  return formData;
}


function formatDateToISO(dateStr) {
  // Assume que dateStr está no formato dd/mm/yyyy
  var parts = dateStr.split('/');
  return `${parts[2]}-${parts[1]}-${parts[0]}`; // Formato yyyy-mm-dd
}

function unmaskCurrencyValue(value) {
  // Remover o símbolo de moeda e substituir vírgula por ponto para converter para o formato numérico correto.
  return parseFloat(value.replace(/[R$\.,]/g, '').replace(',', '.')) / 100;
}

function unmaskValue(element) {
  if(element && element.dataset.mask) {
    return Inputmask.unmask(element.value, { alias: element.dataset.mask });
  } else {
    return element.value;
  }
}

function removeSpecialCharacters(str) {
  return str.replace(/[^\w\s]/gi, '');
}
