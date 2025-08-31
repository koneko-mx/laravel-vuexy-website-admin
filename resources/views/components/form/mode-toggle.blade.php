@props([
  'isSite' => false,   // true => Website, false => Content
  'model',             // string: nombre Livewire, ej: "og_mode"
  'group' => null,     // para IDs únicos, ej: "og", "tw", "schema"
  'size' => 'sm',
  'enableLabel'   => 'Habilitar',
  'overrideLabel' => 'Sobrescribir',
  'inheritLabel'  => 'Heredar',
  'disableLabel'  => 'Deshabilitar',
  'btnClass'      => 'btn btn-outline-secondary',
])

@php
  $uid = $group ? 'mode-'.$group : ('mode-'.uniqid());
  $sizeClass = $size ? "btn-group-{$size}" : '';
@endphp

{{-- 1) Hidden con wire:model.defer (NO dispara AJAX hasta guardar) --}}
<input type="hidden" x-ref="hiddenMode" wire:model.defer="{{ $model }}">

{{-- 2) Radios “puros” controlados por Alpine, ignorados por Livewire --}}
<div {{ $attributes->merge(['class' => "btn-group {$sizeClass}", 'role' => 'group', 'aria-label' => 'Modo']) }}
     wire:ignore
     x-data="modeToggle({ model: @js($model), isSite: @js($isSite) })"
     x-init="init()">

  @if($isSite)
    {{-- Website: Habilitar(override) / Deshabilitar --}}
    <input type="radio" class="btn-check" id="{{ $uid }}-enable"  name="{{ $uid }}" value="override"
           @click="select('override')" :checked="value==='override'">
    <label class="{{ $btnClass }}" for="{{ $uid }}-enable">{{ $enableLabel }}</label>

    <input type="radio" class="btn-check" id="{{ $uid }}-disable" name="{{ $uid }}" value="disable"
           @click="select('disable')"  :checked="value==='disable'">
    <label class="{{ $btnClass }}" for="{{ $uid }}-disable">{{ $disableLabel }}</label>
  @else
    {{-- Content: Heredar / Sobrescribir / Deshabilitar --}}
    <input type="radio" class="btn-check" id="{{ $uid }}-inherit" name="{{ $uid }}" value="inherit"
           @click="select('inherit')"  :checked="value==='inherit'">
    <label class="{{ $btnClass }}" for="{{ $uid }}-inherit">{{ $inheritLabel }}</label>

    <input type="radio" class="btn-check" id="{{ $uid }}-override" name="{{ $uid }}" value="override"
           @click="select('override')" :checked="value==='override'">
    <label class="{{ $btnClass }}" for="{{ $uid }}-override">{{ $overrideLabel }}</label>

    <input type="radio" class="btn-check" id="{{ $uid }}-disable"  name="{{ $uid }}" value="disable"
           @click="select('disable')"  :checked="value==='disable'">
    <label class="{{ $btnClass }}" for="{{ $uid }}-disable">{{ $disableLabel }}</label>
  @endif
</div>

