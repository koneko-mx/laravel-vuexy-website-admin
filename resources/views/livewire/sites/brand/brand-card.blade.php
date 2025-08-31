<div>
    <x-vuexy-admin::form.form id="website-brand-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Marca" class="mb-2">
            <x-vuexy-admin::form.input model="brand_name" label="Nombre comercial" />
            <x-vuexy-admin::form.input model="copyright" label="Copyright" />
            <x-vuexy-admin::form.textarea model="slogan" label="Eslogan de la marca" />
        </x-vuexy-admin::card.basic>
        <div class="row">
            <div class="col-12 text-end mb-4">
                <x-vuexy-admin::button.basic type="submit" variant="primary" size="sm" icon="ti ti-device-floppy" class="btn-save mt-2 mr-2" waves
                    label="Guardar cambios"
                    disabled />
                <x-vuexy-admin::button.basic variant="secondary" size="sm" icon="ti ti-rotate-2" class="btn-cancel mt-2 mr-2" waves
                    label="Cancelar"
                    wire:click="resetForm"
                    disabled />
            </div>
        </div>
    </x-vuexy-admin::form.form>
</div>

@push('page-script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            window.SiteSettingsForm = new formCustomListener({
                formSelector: '#website-brand-card',
                buttonSelectors: ['.btn-save', '.btn-cancel'],
                callbacks: [() => {}],
                dispatchOnSubmit: 'save',
                validationConfig: {
                    fields: {
                        brand_name: {
                            validators: {
                                notEmpty: {
                                    message: 'El nombre comercial es obligatorio.',
                                },
                                stringLength: {
                                    max: 64,
                                    message: 'Máximo 64 caracteres.',
                                },
                            },
                        },
                        copyright: {
                            validators: {
                                stringLength: {
                                    max: 160,
                                    message: 'Máximo 160 caracteres.',
                                },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            eleValidClass: '',
                            rowSelector: '.fv-row',
                        }),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        autoFocus: new FormValidation.plugins.AutoFocus(),
                    },
                }
            });

            registerLivewireHookOnce('morphed', 'vuexy-website-admin::site.brand-card', (component) => {
                SiteSettingsForm.reloadValidation();
            });
        });
    </script>
@endpush
