

function selectClient(client) {
  // Implemente a lógica para lidar com a seleção de um cliente
  console.log('Cliente selecionado:', client);
  const inputSearch = document.getElementById("searchClientInput");
  inputSearch.setAttribute('data-client-id', client.id);
  inputSearch.value = client.name; // Exemplo: Preenche o campo de entrada com o nome do cliente
  document.getElementById("searchResults").innerHTML = ''; // Limpa os resultados de pesquisa
}
// Função JavaScript para fazer a chamada AJAX e buscar clientes
function searchClient() {
  // const input = document.getElementById("searchClientInput");
  if (!document.getElementById('customModal')) {
    console.log("teste")
    return
  } else {
    const input = document.getElementById("searchClientInput");
    
    const query = input.value;
    const resultsContainer = document.getElementById("searchResults");
    if (query.length >= 1) {
      fetch(`searchClient?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(clients => {
          resultsContainer.innerHTML = '';
          clients.forEach(client => {
            const div = document.createElement('div');
            div.className = 'list-group-item list-group-item-action';
            div.textContent = client.name;
            div.style.color = 'black'
            div.style.backgroundColor = '#E1E1E1'


            div.addEventListener('mouseover', function () {
              div.style.backgroundColor = '#FFF';  // Cor quando o mouse está sobre o elemento
            });

            
            div.addEventListener('mouseout', function () {
              div.style.backgroundColor = '#E1E1E1';  // Cor quando o mouse está sobre o elemento
            });



            div.onclick = function () {
              selectClient(client); // Implemente esta função conforme necessário
            };
            resultsContainer.appendChild(div);
          });
        })
        .catch(error => console.error('Erro na busca:', error));
    } else {
      resultsContainer.innerHTML = '';
    }
  }


}


searchClient()