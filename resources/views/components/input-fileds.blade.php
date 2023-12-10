@props(['input', 'mode', 'data'])

@php
$typeInput = isset($input['type']) ? $input['type'] : 'text';
$inputName = isset($input['name']) ? $input['name'] : '';
$inputMask = isset($input['mask']) ? $input['mask'] : '';
$value = $mode === 'view' || $mode === 'edit' ? $data : '';
$disabled = $mode === 'view' ? 'disabled' : '';
$inputId = str_replace(' ', '', $inputName);
@endphp

<style>
  /* Estilo padrão para o elemento select */
  select {
      -webkit-appearance: menulist-button;
      appearance: menulist-button;
  }

</style>

<div class="pl-2">
    <label for="input{{ $inputId }}">{{ $inputName }}</label>

    @if($typeInput === 'select')
        <select name="inputGestante" id="inputGestante" class="form-control form-control-lg rounded" {{ $disabled }}>
            <option value="nao" >Não</option>
            <option value="sim" >Sim</option>
        </select>
    @else
        <input type="{{ $typeInput }}" name="{{ $inputName }}" id="input{{ $inputId }}" class="form-control form-control-lg rounded"
               value="{{ $value }}" {{ $disabled }} @if($inputMask) data-mask="{{ $inputMask }}" @endif>
    @endif
</div>
