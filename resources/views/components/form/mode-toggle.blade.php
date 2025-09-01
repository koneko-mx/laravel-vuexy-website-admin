@props([
  'isSite' => false,
  'model',              // p.ej. "schema_mode"
  'group' => 'schema',  // para IDs únicos y dataset
  'value' => null,      // valor actual: pásalo desde el padre
  'btnClass' => 'btn btn-outline-secondary',
  'size' => 'sm',
  'enableLabel' => 'Habilitar',
  'overrideLabel' => 'Sobrescribir',
  'inheritLabel' => 'Heredar',
  'disableLabel' => 'Deshabilitar',
])

@php
  $uid = 'mode-'.$group;
  $name = $uid.'-name';
  $val = $value ?? ($isSite ? 'override' : 'inherit');
  $sizeClass = $size ? "btn-group-{$size}" : '';
@endphp

{{-- Radios SIN wire:model; los controla JS + delegación (wire:ignore opcional) --}}
<div id="{{ $uid }}-group"
     class="btn-group {{ $sizeClass }}"
     role="group" aria-label="Modo"
     data-hidden="#{{ $uid }}-hidden"
     {{-- opcional: el padre puede setear estos datasets para auto-toggle de UI --}}
     {{ $attributes }}
>
  @if($isSite)
    <input class="btn-check" wire:model="{{ $model }}" type="radio" id="{{ $uid }}-enable"  name="{{ $name }}" value="override" {{ $val === 'override' ?'checked' :'' }}>
    <label class="{{ $btnClass }}" for="{{ $uid }}-enable">{{ $enableLabel }}</label>

    <input class="btn-check" wire:model="{{ $model }}" type="radio" id="{{ $uid }}-disable" name="{{ $name }}" value="disable"  {{ $val === 'disable' ?'checked' :'' }}>
    <label class="{{ $btnClass }}" for="{{ $uid }}-disable">{{ $disableLabel }}</label>
  @else
    <input class="btn-check" wire:model="{{ $model }}" type="radio" id="{{ $uid }}-inherit"  name="{{ $name }}" value="inherit"  {{ $val === 'inherit' ?'checked' :'' }}>
    <label class="{{ $btnClass }}" for="{{ $uid }}-inherit">{{ $inheritLabel }}</label>

    <input class="btn-check" wire:model="{{ $model }}" type="radio" id="{{ $uid }}-override" name="{{ $name }}" value="override" {{ $val === 'override' ?'checked' :'' }}>
    <label class="{{ $btnClass }}" for="{{ $uid }}-override">{{ $overrideLabel }}</label>

    <input class="btn-check" wire:model="{{ $model }}" type="radio" id="{{ $uid }}-disable"  name="{{ $name }}" value="disable"  {{ $val === 'disable' ?'checked' :'' }}>
    <label class="{{ $btnClass }}" for="{{ $uid }}-disable">{{ $disableLabel }}</label>
  @endif
</div>
