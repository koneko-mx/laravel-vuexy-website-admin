<div x-data="{ chatProvider: @entangle('chat_provider') }">
    <x-vuexy-admin::form.form id="website-chat-settings-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Configuración del Chat" class="mb-2">
            {{-- Proveedor --}}
            <div class="mb-4 fv-row">
                <label for="chat_provider" class="form-label">Proveedor</label>
                <select id="chat_provider" name="chat_provider" x-model="chatProvider" wire:model="chat_provider" class="form-select">
                    <option value="">Deshabilitar Chat</option>
                    <option value="whatsapp">WhatsApp</option>
                </select>
            </div>

            {{-- Configuración de WhatsApp --}}
            <div x-show="chatProvider === 'whatsapp'" class="mt-5">
                <h5>WhatsApp</h5>
                <x-vuexy-admin::form.input
                    model="chat_whatsapp_number"
                    label="Número telefónico"
                    placeholder="Número telefónico"
                    required />

                <x-vuexy-admin::form.input
                    model="chat_whatsapp_message"
                    label="Mensaje de saludo"
                    placeholder="Mensaje de saludo"
                    required />
            </div>
        </x-vuexy-admin::card.basic>

        {{-- Botones de acción --}}
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

        {{-- Contenedor para notificaciones --}}
        <div class="notification-container pt-4" wire:ignore></div>
    </x-vuexy-admin::form.form>
</div>
