<div>
    <div id="website-template-card" class="form-custom-listener mb-4">
        <x-vuexy-admin::card.basic title="Plantilla del sitio" subtitle="Elige la plantilla y el color de tema" class="mb-2 position-relative">

            {{-- Overlay de carga --}}
            <div wire:loading.flex wire:target="save,resetForm" class="position-absolute top-0 start-0 w-100 h-100 bg-body bg-opacity-50 align-items-center justify-content-center" style="z-index: 10;">
                <div class="spinner-border" role="status"><span class="visually-hidden">Guardando…</span></div>
            </div>

            <div class="row">
                <div class="col-12 col-md-5">
                    <x-vuexy-admin::form.input
                        model="theme_color"
                        type="color"
                        size="lg"
                        icon="ti ti-color-swatch"
                        label="Color del sitio"
                    />
                    <small class="text-muted block">Usa un color adecuado para la barra de navegador.</small>
                    @error('theme_color')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-7">
                    <label for="template" class="form-label">Plantilla</label>
                    <select id="template" name="template" wire:model="template" class="form-select" data-choices data-choices-search-true>
                        <option value="">Seleccione una plantilla</option>
                        @foreach ($template_options as $group => $templates)
                            <optgroup label="{{ $group }}">
                                @foreach ($templates['items'] as $key => $tpl)
                                    <option value="{{ $key }}">{{ $tpl }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('template')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Estado actual / resumen --}}
            <div class="mt-3 d-flex align-items-center gap-2">
                <span class="badge bg-label-primary">Actual: {{ $template ?: '—' }}</span>
                <span class="badge" style="background-color: {{ $theme_color }};">&nbsp;</span>
                <span>{{ $theme_color }}</span>
            </div>

        </x-vuexy-admin::card.basic>

        <div class="row">
            <div class="col-12 text-end mb-4">
                <x-vuexy-admin::button.basic
                    variant="primary"
                    size="sm"
                    icon="ti ti-device-floppy"
                    class="btn-save mt-2 me-2"
                    label="Guardar cambios"
                    wire:click="save"
                    wire:loading.attr="disabled"
                    wire:target="save"
                />
                <x-vuexy-admin::button.basic
                    variant="secondary"
                    size="sm"
                    icon="ti ti-rotate-2"
                    class="btn-cancel mt-2"
                    label="Cancelar"
                    wire:click="resetForm"
                    wire:loading.attr="disabled"
                    wire:target="resetForm"
                />
            </div>
        </div>

        <div class="notification-container mb-4" wire:ignore></div>
    </div>
</div>

@push('page-script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Mantén tu listener para habilitar/deshabilitar botones por cambios
        window.TemplateForm = new formCustomListener({
            formSelector: '#website-template-card',
            buttonSelectors: ['.btn-save', '.btn-cancel'],
        });

        // Re-init después de morph de Livewire
        registerLivewireHookOnce('morphed', 'vuexy-website-admin::site.template-card', () => {
            TemplateForm.reloadValidation();

            // Inicialización opcional de Choices.js si está presente globalmente
            /*
            const select = document.querySelector('#website-template-card select[data-choices]');
            if (select && window.Choices && !select.dataset.choicesInited) {
                new Choices(select, {
                    searchEnabled: true,
                    itemSelectText: '',
                    shouldSort: false,
                });
                select.dataset.choicesInited = '1';
            }
            */
        });
    });
</script>
@endpush
