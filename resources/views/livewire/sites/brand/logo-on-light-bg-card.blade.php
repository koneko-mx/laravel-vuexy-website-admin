<div>
    {{-- CARD: Logotipo regular sobre fondo claro --}}
    <div id="logo-on-light-bg-card" class="mb-4 position-relative">
        <x-vuexy-admin::card.basic title="Logotipo sobre fondo claro" subtitle="Formato recomendado: PNG/WebP con fondo transparente" class="mb-2">
            <div wire:loading.flex wire:target="saveVertical,upload_logo" class="position-absolute top-0 start-0 w-100 h-100 bg-body bg-opacity-50 align-items-center justify-content-center" style="z-index:10;">
                <div class="spinner-border" role="status"><span class="visually-hidden">Procesando…</span></div>
            </div>

            <x-vuexy-admin::form.input
                type="file"
                label="Archivo de logotipo"
                model="upload_logo"
                accept="image/png,image/jpeg,image/webp"
            />
            @error('upload_logo')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror

            @php
                $srcV = $upload_logo ? $upload_logo->temporaryUrl() : (str_starts_with($logo_path, '../') ? asset($logo_path) : asset('storage/'.$logo_path));
            @endphp

            <div class="mb-3">
                <div class="d-flex justify-content-center align-items-center bg-slate-100 p-4 rounded-3" style="min-height:240px;">
                    <img src="{{ $srcV }}" alt="Vista previa logotipo" style="max-height:220px; object-fit:contain;"/>
                </div>
                <small class="text-muted">Se generan tamaños small/medium/large automáticamente.</small>
            </div>
        </x-vuexy-admin::card.basic>

        <div class="row">
            <div class="col-12 text-end mb-4">
                <x-vuexy-admin::button.basic variant="primary" size="sm" icon="ti ti-device-floppy" class="btn-save mt-2 mr-2" waves
                    label="Guardar cambios"
                    wire:click="saveVertical"
                    wire:loading.attr="disabled"
                    wire:target="resetVertical,upload_logo"
                    disabled="{{ $upload_logo === null }}"
                />
                <x-vuexy-admin::button.basic variant="secondary" size="sm" icon="ti ti-rotate-2" class="btn-cancel mt-2 mr-2" waves
                    label="Cancelar"
                    wire:click="resetVertical"
                    wire:loading.attr="disabled"
                    wire:target="saveVertical,upload_logo"
                    disabled="{{ $upload_logo === null }}"
                />
            </div>
        </div>

        <div class="notification-container mb-4" wire:ignore></div>
    </div>

    {{-- CARD: Logotipo horizontal sobre fondo claro --}}
    <div id="logo-h-on-light-bg-card" class="mb-4 position-relative">
        <x-vuexy-admin::card.basic title="Logotipo horizontal sobre fondo claro" subtitle="Proporción sugerida 4:1 o 5:1, fondo transparente" class="mb-2">
            <div wire:loading.flex wire:target="saveHorizontal,upload_logo_h" class="position-absolute top-0 start-0 w-100 h-100 bg-body bg-opacity-50 align-items-center justify-content-center" style="z-index:10;">
                <div class="spinner-border" role="status"><span class="visually-hidden">Procesando…</span></div>
            </div>

            <x-vuexy-admin::form.input
                type="file"
                label="Archivo de logotipo horizontal"
                model="upload_logo_h"
                accept="image/png,image/jpeg,image/webp"
            />
            @error('upload_logo_h')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror

            @php
                $srcH = $upload_logo_h ? $upload_logo_h->temporaryUrl() : (str_starts_with($logo_path_h, '../') ? asset($logo_path_h) : asset('storage/'.$logo_path_h));
            @endphp

            <div class="mb-3">
                <div class="d-flex justify-content-center align-items-center bg-slate-100 p-4 rounded-3" style="min-height:140px;">
                    <img src="{{ $srcH }}" alt="Vista previa logotipo horizontal" style="max-height:90px; max-width:100%; object-fit:contain;"/>
                </div>
                <small class="text-muted">Se generan tamaños small/medium/large automáticamente para la variante <code>h</code>.</small>
            </div>
        </x-vuexy-admin::card.basic>

        <div class="row">
            <div class="col-12 text-end mb-4">
                <x-vuexy-admin::button.basic variant="primary" size="sm" icon="ti ti-device-floppy" class="btn-save mt-2 mr-2" waves
                    label="Guardar cambios"
                    wire:click="saveHorizontal"
                    wire:loading.attr="disabled"
                    wire:target="saveHorizontal,upload_logo_h"
                    disabled="{{ $upload_logo_h === null }}"
                />
                <x-vuexy-admin::button.basic variant="secondary" size="sm" icon="ti ti-rotate-2" class="btn-cancel mt-2 mr-2" waves
                    label="Cancelar"
                    wire:click="resetHorizontal"
                    wire:loading.attr="disabled"
                    wire:target="resetHorizontal,upload_logo_h"
                    disabled="{{ $upload_logo_h === null }}"
                />
            </div>
        </div>

        <div class="notification-container mb-4" wire:ignore></div>
    </div>
</div>

@push('page-script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // (Opcional) Si usas un listener genérico para habilitar botones por cambios:
        if (window.formCustomListener) {
            new formCustomListener({
                formSelector: '#logo-on-light-bg-card',
                buttonSelectors: ['#logo-on-light-bg-card .btn-save', '#logo-on-light-bg-card .btn-cancel'],
            });
            new formCustomListener({
                formSelector: '#logo-h-on-light-bg-card',
                buttonSelectors: ['#logo-h-on-light-bg-card .btn-save', '#logo-h-on-light-bg-card .btn-cancel'],
            });
        }
    });
</script>
@endpush
