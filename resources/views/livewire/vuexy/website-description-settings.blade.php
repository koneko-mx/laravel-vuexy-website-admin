<div>
    <div id="website-description-settings-card" class="form-custom-listener mb-4">
        <x-vuexy-admin::card.basic title="Datos de la aplicación" class="mb-2">
            <x-vuexy-admin::form.input  model="title" label="Titulo del sitio web" />
            <x-vuexy-admin::form.textarea model="description" label="Descripción del sitio web" />
        </x-vuexy-admin::card.basic>
        <div class="row">
            <div class="col-lg-12 text-end">
                <x-vuexy-admin::button.basic
                    variant="primary"
                    size="sm"
                    icon="ti ti-device-floppy"
                    label="Guardar cambios"
                    disabled
                    wire:click="save"
                    class="btn-save mt-2 mr-2"
                    waves />
                <x-vuexy-admin::button.basic
                    variant="secondary"
                    size="sm"
                    icon="ti ti-rotate-2"
                    disabled
                    label="Cancelar"
                    wire:click="resetForm"
                    class="btn-cancel mt-2 mr-2"
                    waves />
            </div>
        </div>
        <div class="notification-container pt-4" wire:ignore></div>
    </div>
</div>
