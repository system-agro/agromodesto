<table class="table table-bordered">
  <thead>
    <tr>
      @foreach ($columns as $column)
        <th>{{ $column }}</th>
      @endforeach
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $contact)
      <tr data-id="{{ $contact->id }}">
        @foreach($columns as $column) 
          <td>{{ $contact->{$columnMapping[$column]} }}</td>
        @endforeach
        <td class="col-1">
          <button id="edit" class="btn btn-primary">Editar</button>
          <button id="view" class="btn btn-success" onclick="visualizarItem({{ $contact->id }})">Visualizar</button>
          <button id="delete" class="btn btn-danger" onclick="deleteClient({{ $contact->id }})">Excluir</button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
