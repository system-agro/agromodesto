<!-- table-component.blade.php -->
<table class="table table-bordered">
  <thead>
    <tr>
      @foreach ($columns as $column)
        <th>{{ $column }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach($data as $contact)
      <tr>
        @foreach($columns as $column) 
            <td>{{ $contact->{$columnMapping[$column]} }}</td>
        @endforeach
      </tr>
    @endforeach
  </tbody>
</table>
