@props(['input', 'mode', 'data'])

@php
// Certifique-se de que 'input' e 'data' são arrays antes de tentar acessar as chaves
$inputName = isset($input['name']) ? $input['name'] : '';
$inputMask = isset($input['mask']) ? $input['mask'] : '';
$value = $mode === 'view' || $mode === 'edit' ? $data : '';
$disabled = $mode === 'view' ? 'disabled' : '';
$inputId = str_replace(' ', '', $inputName);
@endphp


<div class="p-3">
  <label for="input{{ $inputId }}">{{ $inputName }}</label>
  <input type="text" name="{{ $inputName }}" id="input{{ $inputId }}" class="form-control form-control-lg rounded"
    value="{{ $value }}" {{ $disabled }} @if($inputMask) data-mask="{{ $inputMask }}" @endif>
</div>
