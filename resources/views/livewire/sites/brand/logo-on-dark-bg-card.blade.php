<div>
    {{-- CARD: Logotipo (fondo oscuro) --}}
    <div id="logo-on-dark-bg-card" class="mb-4 position-relative">
        <x-vuexy-admin::card.basic title="Logotipo sobre fondo oscuro" subtitle="Formato recomendado: PNG/WebP con fondo transparente" class="mb-2">
            <div wire:loading.flex wire:target="saveVerticalDark,upload_logo_dark" class="position-absolute top-0 start-0 w-100 h-100 bg-body bg-opacity-50 align-items-center justify-content-center" style="z-index:10;">
                <div class="spinner-border" role="status"><span class="visually-hidden">Procesando…</span></div>
            </div>

            <x-vuexy-admin::form.input
                type="file"
                label="Archivo de logotipo"
                model="upload_logo_dark"
                accept="image/png,image/jpeg,image/webp"
            />
            @error('upload_logo_dark')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror

            @php
                $srcDark = $upload_logo_dark
                    ? $upload_logo_dark->temporaryUrl()
                    : (str_starts_with($logo_dark_path, '../') ? asset($logo_dark_path) : asset('storage/'.$logo_dark_path));
            @endphp

            <div class="mb-3">
                <div class="d-flex justify-content-center align-items-center p-4 rounded-3" style="min-height:240px; background:#0b1220;">
                    <img src="{{ $srcDark }}" alt="Vista previa logotipo oscuro" style="max-height:220px; object-fit:contain;"/>
                </div>
                <small class="text-muted">Se generan tamaños small/medium/large automáticamente para la variante <code>dark</code>.</small>
            </div>
        </x-vuexy-admin::card.basic>

        <div class="row">
            <div class="col-12 text-end mb-4">
                <x-vuexy-admin::button.basic variant="primary" size="sm" icon="ti ti-device-floppy" class="btn-save mt-2 mr-2" waves
                    label="Guardar cambios"
                    wire:click="saveVerticalDark"
                    wire:loading.attr="disabled"
                    wire:target="saveVerticalDark,upload_logo_dark"
                    disabled="{{ $upload_logo_dark === null }}"
                />
                <x-vuexy-admin::button.basic variant="secondary" size="sm" icon="ti ti-rotate-2" class="btn-cancel mt-2 mr-2" waves
                    label="Cancelar"
                    wire:click="resetVerticalDark"
                    wire:loading.attr="disabled"
                    wire:target="resetVerticalDark,upload_logo_dark"
                    disabled="{{ $upload_logo_dark === null }}"
                />
            </div>
        </div>

        <div class="notification-container mb-4" wire:ignore></div>
    </div>

    {{-- CARD: Logotipo horizontal (fondo oscuro) --}}
    <div id="logo-h-on-dark-bg-card" class="mb-4 position-relative">
        <x-vuexy-admin::card.basic title="Logotipo horizontal sobre fondo oscuro" subtitle="Sugerido ~4:1 o 5:1, PNG/WebP con transparencia" class="mb-2">
            <div wire:loading.flex wire:target="saveHorizontalDark,upload_logo_h_dark" class="position-absolute top-0 start-0 w-100 h-100 bg-body bg-opacity-50 align-items-center justify-content-center" style="z-index:10;">
                <div class="spinner-border" role="status"><span class="visually-hidden">Procesando…</span></div>
            </div>

            <x-vuexy-admin::form.input
                type="file"
                label="Archivo de logotipo horizontal"
                model="upload_logo_h_dark"
                accept="image/png,image/jpeg,image/webp"
            />
            @error('upload_logo_h_dark')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror

            @php
                $srcHDark = $upload_logo_h_dark
                    ? $upload_logo_h_dark->temporaryUrl()
                    : (str_starts_with($logo_h_dark_path, '../') ? asset($logo_h_dark_path) : asset('storage/'.$logo_h_dark_path));
            @endphp

            <div class="mb-3">
                <div class="d-flex justify-content-center align-items-center p-4 rounded-3" style="min-height:140px; background:#0b1220;">
                    <img src="{{ $srcHDark }}" alt="Vista previa logotipo horizontal oscuro" style="max-height:90px; max-width:100%; object-fit:contain;"/>
                </div>
                <small class="text-muted">Se generan tamaños small/medium/large automáticamente para la variante <code>h_dark</code>.</small>
            </div>
        </x-vuexy-admin::card.basic>

        <div class="row">
            <div class="col-12 text-end mb-4">
                <x-vuexy-admin::button.basic variant="primary" size="sm" icon="ti ti-device-floppy" class="btn-save mt-2 mr-2" waves
                    label="Guardar cambios"
                    wire:click="saveHorizontalDark"
                    wire:loading.attr="disabled"
                    wire:target="saveHorizontalDark,upload_logo_h_dark"
                    disabled="{{ $upload_logo_h_dark === null }}"
                />
                <x-vuexy-admin::button.basic variant="secondary" size="sm" icon="ti ti-rotate-2" class="btn-cancel mt-2 mr-2" waves
                    label="Cancelar"
                    wire:click="resetHorizontalDark"
                    wire:loading.attr="disabled"
                    wire:target="resetHorizontalDark,upload_logo_h_dark"
                    disabled="{{ $upload_logo_h_dark === null }}"
                />
            </div>
        </div>

        <div class="notification-container mb-4" wire:ignore></div>
    </div>
</div>

@push('page-script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.formCustomListener) {
            new formCustomListener({
                formSelector: '#logo-on-dark-bg-card',
                buttonSelectors: ['#logo-on-dark-bg-card .btn-save', '#logo-on-dark-bg-card .btn-cancel'],
            });
            new formCustomListener({
                formSelector: '#logo-h-on-dark-bg-card',
                buttonSelectors: ['#logo-h-on-dark-bg-card .btn-save', '#logo-h-on-dark-bg-card .btn-cancel'],
            });
        }
    });
</script>
@endpush
