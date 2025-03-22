import '@vuexy-admin/notifications/LivewireNotification.js';
import FormCustomListener from '@vuexy-admin/forms/formCustomListener';
import registerLivewireHookOnce from '@vuexy-admin/livewire/registerLivewireHookOnce';

// Inicializar formularios de ajustes de social media
window.SocialSettingsForm = new FormCustomListener({
    formSelector: '#website-social-settings-card',
    buttonSelectors: ['.btn-save', '.btn-cancel'],
    callbacks: [() => {}],
    dispatchOnSubmit: 'save',
    validationConfig: {
        fields: {
            social_whatsapp: {
                validators: {
                    callback: {
                        message: 'Por favor, introduce un número de teléfono válido para México.',
                        callback: function (input) {
                            // Si el campo está vacío, no hacemos validación
                            if (input.value.trim() === '') {
                                return true; // Permitir vacío
                            }

                            // Si no está vacío, validamos el formato del número
                            const cleanValue = input.value.replace(/\D/g, '');
                            const regex = /^[1-9]\d{9}$/; // Exactamente 10 dígitos

                            return regex.test(cleanValue); // Valida solo si hay un número
                        }
                    }
                }
            },
            social_whatsapp_message: {
                validators: {
                    stringLength: {
                        max: 500,
                        message: 'El mensaje no puede exceder los 500 caracteres.'
                    },
                    callback: {
                        message: 'El mensaje es obligatorio.',
                        callback: function (input) {
                            // Obtener el valor de 'social_whatsapp'
                            const whatsappNumber = document.querySelector('#social_whatsapp').value.trim();

                            // Si 'social_whatsapp' tiene un valor, entonces el mensaje es obligatorio
                            if (whatsappNumber !== '') {
                                return input.value.trim() !== ''; // El mensaje no puede estar vacío
                            }

                            return true; // Si 'social_whatsapp' está vacío, no validamos 'social_whatsapp_message'
                        }
                    }
                }
            },
            social_facebook: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_instagram: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_linkedin: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_tiktok: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_x_twitter: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_google: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_pinterest: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_youtube: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            },
            social_vimeo: {
                validators: {
                    uri: {
                        message: 'Por favor, introduce una URL válida.'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: '.fv-row',
                messageContainer: '.fv-message'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }
});

registerLivewireHookOnce('morphed', 'vuexy-website-admin::social-media-settings', (component) => {
    SocialSettingsForm.reloadValidation();
});
