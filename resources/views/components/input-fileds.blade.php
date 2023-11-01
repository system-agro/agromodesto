@props(['input', 'mode', 'data'])

@php
    $value = $mode === 'view' || $mode === 'edit' ? $data[$input] : '';
    $disabled = $mode === 'view' ? 'disabled' : '';
    $inputId = str_replace(' ', '', $input);
@endphp

<div class="p-3">
    <label>{{ $input }}</label>
    <input type="text" name="{{ $input }}" id="input{{ $inputId }}" class="form-control form-control-lg rounded" value="{{ $value }}" {{ $disabled }}>
</div>
