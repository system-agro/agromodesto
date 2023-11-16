<table class="table table-bordered">
  <thead>
    <tr>
      @foreach ($columns as $column)
        <th>{{ $column['name'] }}</th>
      @endforeach
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $contact)
      <tr data-id="{{ $contact->id }}">
        @foreach($columns as $column)
          @php
            $maskType = $column['mask'] ?? '';
            $columnName = $column['name'];
          @endphp
          <td data-column="{{$columnName}}" data-mask="{{ $maskType }}">{{ $contact->{$columnMapping[$columnName]} }}</td>
        @endforeach
        <td class="col-1">
          <button id="edit" class="btn btn-primary" onclick="onEditModal({{ $contact->id }})">Editar</button>
          <button id="view" class="btn btn-success" onclick="visualizarItem({{ $contact->id }})">Visualizar</button>
          <button id="delete" class="btn btn-danger" onclick="deleteData({{ $contact->id }})">Excluir</button>
          <button id="relatorio" class="btn btn-light" onclick="downloadPDF({{ $contact->id }})">Relatorio</button>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<script src="{{ asset('js/tableMask.js')}}"></script>



