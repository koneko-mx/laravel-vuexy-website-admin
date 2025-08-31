<div>
    <x-vuexy-admin::form.form id="website-description-card" class="form-custom-listener mb-4" whitOutId whitOutMode>
        <x-vuexy-admin::card.basic title="Sitio web" class="mb-2">
            <x-vuexy-admin::form.input model="domain" label="Nombre de dominio" />
            <x-vuexy-admin::form.input model="title" label="Titulo del sitio" />
            <x-vuexy-admin::form.input model="author" label="Autor del sitio" />
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
                formSelector: '#website-description-card',
                buttonSelectors: ['.btn-save', '.btn-cancel'],
                callbacks: [() => {}],
                dispatchOnSubmit: 'save',
                validationConfig: {
                    fields: {
                        domain: {
                            validators: {
                                notEmpty: {
                                    message: 'El dominio es obligatorio.',
                                },
                                regexp: {
                                    // Sin protocolo, sin www, dominio válido (con punto), labels 1–63 chars
                                    regexp: /^(?!https?:\/\/)(?!www\.)(?=.{1,253}$)(?!-)[A-Za-z0-9-]{1,63}(?<!-)(?:\.(?!-)[A-Za-z0-9-]{1,63}(?<!-))+$/,
                                    message: 'Usa un dominio válido sin protocolo ni www (ej: ejemplo.com).',
                                },
                            },
                        },
                        title: {
                            validators: {
                                notEmpty: {
                                    message: 'El título es obligatorio.',
                                },
                                stringLength: {
                                    max: 96,
                                    message: 'Máximo 96 caracteres.',
                                },
                            },
                        },
                        author: {
                            validators: {
                                // Opcional: solo valida si hay valor
                                stringLength: {
                                    max: 70,
                                    message: 'Máximo 70 caracteres.',
                                },
                                regexp: {
                                    // Letras, números, espacios y puntuación común en nombres
                                    regexp: /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9 .,'’\-()]+$/,
                                    message: 'Solo letras, números y puntuación básica.',
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

            registerLivewireHookOnce('morphed', 'vuexy-website-admin::site.description-card', (component) => {
                SiteSettingsForm.reloadValidation();
            });
        });
    </script>
@endpush
