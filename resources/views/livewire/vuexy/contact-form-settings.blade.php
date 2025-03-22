<div>
    <x-vuexy-admin::form.form id="website-contact-form-settings-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Configuración del Formulario" class="mb-2">
            <x-vuexy-admin::form.input model="to_email" label="Correo principal" type="email" icon="ti ti-mail" placeholder="Email donde se enviarán los mensajes" required />
            <x-vuexy-admin::form.input model="to_email_cc" label="Correo CC" type="email" icon="ti ti-mail-forward" placeholder="Email adicional para copia" helperText="Email adicional que recibirá una copia de los mensajes" />
            <x-vuexy-admin::form.input model="subject" label="Asunto del correo" placeholder="Asunto predeterminado del email" required />
            <x-vuexy-admin::form.textarea model="submit_message" label="Mensaje de Confirmación" placeholder="Mensaje que se mostrará al usuario cuando envíe el formulario" required />
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
