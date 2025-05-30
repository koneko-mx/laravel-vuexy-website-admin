<div>
    <x-vuexy-admin::form.form id="website-social-settings-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Redes sociales" class="mb-2">
            <div class="row">
                <div class="col-md-6">
                    <x-vuexy-admin::form.input model="social_whatsapp" label="WhatsApp" icon="ti ti-brand-whatsapp" placeholder="Enlace de WhatsApp" />
                    <x-vuexy-admin::form.input model="social_whatsapp_message" placeholder="Mensaje de saludo WhatsApp" />
                    <x-vuexy-admin::form.input model="social_facebook" label="Facebook" icon="ti ti-brand-facebook" placeholder="Enlace de Facebook" />
                    <x-vuexy-admin::form.input model="social_instagram" label="Instagram" icon="ti ti-brand-instagram" placeholder="Enlace de Instagram" />
                    <x-vuexy-admin::form.input model="social_linkedin" label="LinkedIn" icon="ti ti-brand-linkedin" placeholder="Enlace de LinkedIn" />
                    <x-vuexy-admin::form.input model="social_tiktok" label="TikTok" icon="ti ti-brand-tiktok" placeholder="Enlace de TikTok" />
                </div>
                <div class="col-md-6">
                    <x-vuexy-admin::form.input model="social_x_twitter" label="X (Twitter)" icon="ti ti-brand-twitter" placeholder="Enlace de X (Twitter)" />
                    <x-vuexy-admin::form.input model="social_google" label="Google" icon="ti ti-brand-google" placeholder="Enlace de Google" />
                    <x-vuexy-admin::form.input model="social_pinterest" label="Pinterest" icon="ti ti-brand-pinterest" placeholder="Enlace de Pinterest" />
                    <x-vuexy-admin::form.input model="social_youtube" label="YouTube" icon="ti ti-brand-youtube" placeholder="Enlace de YouTube" />
                    <x-vuexy-admin::form.input model="social_vimeo" label="Vimeo" icon="ti ti-brand-vimeo" placeholder="Enlace de Vimeo" />
                </div>
            </div>
        </x-vuexy-admin::card.basic>
        <div class="row">
            <div class="col-lg-12 text-end">
                <x-vuexy-admin::button.basic
                    type="submit"
                    variant="primary"
                    size="sm"
                    icon="ti ti-device-floppy"
                    data-loading-text="Guardando..."
                    label="Guardar cambios"
                    disabled
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
    </x-vuexy-admin::form.form>
</div>
