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
          <button class="btn btn-primary btn-edit" data-contact-id="{{ $contact->id }}">Editar</button>
          <button class="btn btn-success btn-view" data-contact-id="{{ $contact->id }}">Visualizar</button>
          <button class="btn btn-danger btn-delete" data-contact-id="{{ $contact->id }}">Excluir</button>
          @if($temRelatorio ?? false)
            <button class="btn btn-light btn-relatorio" data-contact-id="{{ $contact->id }}">Relatorio</button>
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<script src="{{ asset('js/tableMask.js')}}"></script>
