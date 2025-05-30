<div x-data="{ googleanalyticsEnabled: @entangle('google_analytics_enabled') }">
    <x-vuexy-admin::form.form id="website-analytics-settings-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Google Analytics" class="mb-2">
            <div class="mb-6">
                <a href="https://analytics.google.com/analytics/web/">https://analytics.google.com/analytics/web/</a>
            </div>
            <x-vuexy-admin::form.checkbox model="google_analytics_enabled" label="Habilitar Google Analytics" switch />
            <x-vuexy-admin::form.input model="google_analytics_id" label="ID de medición de Google Analytics" icon="fab fa-google" placeholder="XX-12345678901" x-bind:disabled='!googleanalyticsEnabled' />
        </x-vuexy-admin::card.basic>
        <div class="row">
            <div class="col-lg-12 text-end">
                <x-vuexy-admin::button.basic
                    type="submit"
                    variant="primary"
                    size="sm"
                    icon="ti ti-device-floppy"
                    label="Guardar cambios"
                    disabled
                    class="btn-save mt-2 mr-2 waves-effect waves-light"
                    waves
                    data-loading-text="Guardando..." />
                <x-vuexy-admin::button.basic
                    variant="secondary"
                    size="sm"
                    icon="ti ti-rotate-2"
                    label="Cancelar"
                    wire:click="resetForm"
                    class="btn-cancel mt-2 mr-2 waves-effect waves-light"
                    waves />
            </div>
        </div>
        <div class="notification-container pt-4" wire:ignore></div>
    </x-vuexy-admin::form.form>
</div>
