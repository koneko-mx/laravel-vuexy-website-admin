<div>
    <div id="website-visibility-security-card" class="form-custom-listener mb-4">
        <x-vuexy-admin::card.basic title="Visibilidad y seguridad" class="mb-2">
            <x-vuexy-admin::form.checkbox model="www_redirect" switch label="Redirigir sin www." />
            <x-vuexy-admin::form.checkbox model="force_https" switch label="Forzar HTTPS" />
            <hr>
            <x-vuexy-admin::form.select model="status" label="Estado del sitio" :options="$status_options" no-placeholder />
            <hr>
            <x-vuexy-admin::form.select model="coming_soon_content_id" label="Pagina de proximamente" :options="$contents_options" />
            <x-vuexy-admin::form.select model="maintenance_content_id" label="Pagina de mantenimiento" :options="$contents_options" />
        </x-vuexy-admin::card.basic>
        <div class="row">
            <div class="col-12 text-end mb-4">
                <x-vuexy-admin::button.basic variant="primary" size="sm" icon="ti ti-device-floppy" class="btn-save mt-2 mr-2" waves
                    label="Guardar cambios"
                    wire:click="save"
                    disabled />
                <x-vuexy-admin::button.basic variant="secondary" size="sm" icon="ti ti-rotate-2" class="btn-cancel mt-2 mr-2" waves
                    label="Cancelar"
                    wire:click="resetForm"
                    disabled />
            </div>
        </div>
        <div class="notification-container mb-4" wire:ignore></div>
    </div>
</div>

@push('page-script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Inicializar formularios de Visibilidad y seguridad
            window.VisibilitySecuritySettingsForm = new formCustomListener({
                formSelector: '#website-visibility-security-card',
                buttonSelectors: ['.btn-save', '.btn-cancel'],
            });

            registerLivewireHookOnce('morphed', 'vuexy-website-admin::site.visibility-security-card', (component) => {
                VisibilitySecuritySettingsForm.reloadValidation();
            });
        });
    </script>
@endpush
