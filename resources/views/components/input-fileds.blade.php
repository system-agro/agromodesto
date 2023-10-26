@props(['input', 'mode', 'data'])

@php
    $value = $mode === 'view' ? $data[$input] : '';
    $disabled = $mode === 'view' ? 'disabled' : '';
@endphp

<div>
    <label>{{ $input }}</label>
    <input type="text" name="{{ $input }}" id="{{ $input }}" class="form-control form-control-lg rounded" value="{{ $value }}" {{ $disabled }}>
</div>
