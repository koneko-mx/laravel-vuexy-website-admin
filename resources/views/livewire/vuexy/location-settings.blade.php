<div>
    <x-vuexy-admin::form.form id="website-location-settings-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Ubicación y Horarios" class="mb-2">
            <x-vuexy-admin::form.input model="direccion" label="Dirección" icon="ti ti-map-pin" placeholder="Dirección" />
            <div class="row">
                <x-vuexy-admin::form.input type="number" step="0.00000" model="location_lat" label="Latitud" icon="ti ti-map-pin-2" placeholder="Latitud" parentClass="col-6" align="center" />
                <x-vuexy-admin::form.input type="number" step="0.00000" model="location_lng" label="Longitud" icon="ti ti-map-pin-2" placeholder="Longitud" parentClass="col-6" align="center" />
            </div>
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
                    class="btn-save mt-2 mr-2"
                    waves
                    data-loading-text="Guardando..." />
                <x-vuexy-admin::button.basic
                    variant="secondary"
                    size="sm"
                    icon="ti ti-rotate-2"
                    label="Cancelar"
                    wire:click="resetForm"
                    class="btn-cancel mt-2 mr-2"
                    waves />
            </div>
        </div>
        <div class="notification-container pt-4" wire:ignore></div>
    </x-vuexy-admin::form.form>
</div>
