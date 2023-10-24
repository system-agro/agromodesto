@props(['input', 'mode'])

@php
    $value = $mode === 'view' ? 'Valor' : '';
    $disabled = $mode === 'view' ? 'disabled' : '';
@endphp

<div>
    <label>{{ $input }}</label>
    <input type="text" name="{{ $input }}" id="{{ $input }}" class="form-control form-control-lg rounded" value="{{ $value }}" {{ $disabled }}>
</div>
