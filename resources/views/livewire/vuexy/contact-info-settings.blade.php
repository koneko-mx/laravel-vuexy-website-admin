<div>
    <x-vuexy-admin::form.form id="website-contact-info-settings-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Información de contacto" class="mb-2">
            <div class="row">
                <x-vuexy-admin::form.input model="phone_number" label="Número telefónico" icon="ti ti-phone" placeholder="Número telefónico" parentClass="col-md-8" />
                <x-vuexy-admin::form.input model="phone_number_ext" label="Extención telefónica" icon="ti ti-phone-plus" placeholder="Ext. núm." parentClass="col-md-4" />
            </div>
            <div class="row">
                <x-vuexy-admin::form.input model="phone_number_2" label="Número telefónico alternativo" icon="ti ti-phone" placeholder="Número telefónico alternativo" parentClass="col-md-8" />
                <x-vuexy-admin::form.input model="phone_number_2_ext" label="Extención telefónica²" icon="ti ti-phone-plus" placeholder="Ext. núm.²" parentClass="col-md-4" />
            </div>
            <x-vuexy-admin::form.input model="email" label="Correo electrónico" icon="ti ti-mail" type="email" placeholder="Correo electrónico" />
            <x-vuexy-admin::form.input model="horario" label="Horario" icon="ti ti-clock" placeholder="Horario" />
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
