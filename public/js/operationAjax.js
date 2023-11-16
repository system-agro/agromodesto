async function fetchData(endpoint, method = 'GET', data = null) {
  let config = {
    method: method,
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  };

  if (data) {
    config.body = JSON.stringify(data);
  }
  
  try {
    const response = await fetch(endpoint, config);
    if (!response.ok) {
      console.error('Error calling the API:', response.status);
      return null;
    }
    return await response.json();
  } catch (error) {
    console.error('An error occurred:', error);
    return null;
  }
}

async function retrieveItem(endpoint, id) {
  return await fetchData(`${endpoint}/detail/${id}`);
}

async function deleteItem(endpoint, id) {
  return await fetchData(`${endpoint}/delete/${id}`, 'DELETE');
}

async function createItem(endpoint, data) {
  return await fetchData(`${endpoint}/save`, 'POST', data);
}

async function updateItem(endpoint, id, data) {
  return await fetchData(`${endpoint}/update/${id}`, 'PUT', data);
}
