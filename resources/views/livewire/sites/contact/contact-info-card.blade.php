<div x-data="{}" wire:key="contact-info-card-{{ $site->id }}">
  <x-vuexy-admin::form.card-form
    id="website-contact-info-card"
    title="Información de contacto"
    subtitle="Teléfonos, extensiones, correo y nota de horario"
    showActions
    wire:submit.prevent="save"
  >
    <div class="row">
      <div class="col-md-8">
        <x-vuexy-admin::form.input model="phone_number" id="phone_number" label="Número telefónico" icon="ti ti-phone" placeholder="+525512345678" autocomplete="off" />
      </div>
      <div class="col-md-4">
        <x-vuexy-admin::form.input model="phone_number_ext" id="phone_number_ext" label="Extensión" icon="ti ti-phone-plus" placeholder="Ext." autocomplete="off" />
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <x-vuexy-admin::form.input model="phone_number_2" id="phone_number_2" label="Número alternativo" icon="ti ti-phone" placeholder="+525512345679" autocomplete="off" />
      </div>
      <div class="col-md-4">
        <x-vuexy-admin::form.input model="phone_number_2_ext" id="phone_number_2_ext" label="Extensión²" icon="ti ti-phone-plus" placeholder="Ext." autocomplete="off" />
      </div>
    </div>

    <x-vuexy-admin::form.input model="email" id="email" type="email" label="Correo electrónico" icon="ti ti-mail" placeholder="contacto@tu-dominio.com" autocomplete="off" />

    <x-vuexy-admin::form.input model="hours_text" id="hours_text" label="Horario (texto corto)" icon="ti ti-clock" placeholder="Lun–Vie 9:00–18:00" autocomplete="off" />

    <small class="text-muted d-block mt-1">Para horarios detallados por día, usa la tarjeta <em>BusinessHours</em> (sugerida abajo).</small>

    <div class="notification-container mb-4" wire:ignore></div>
  </x-vuexy-admin::form.card-form>
</div>

@push('page-script')
<script>
  document.addEventListener('livewire:init', () => {
    const e164 = /^[+]?[1-9][0-9]{4,19}$/;
    const ext  = /^\d{1,10}$/;

    window.ContactInfoSettingsForm = new formCustomListener({
      formSelector:    '#website-contact-info-card',
      buttonSelectors: ['.btn-save', '.btn-cancel'],
      dispatchOnSubmit: 'save',
      fieldsValidation: {
        phone_number:     { validators: { callback: { message: 'Formato E.164 inválido.', callback: i => { const v=(i.value||'').trim(); return !v || e164.test(v); } } } },
        phone_number_ext: { validators: { callback: { message: 'Extensión inválida (1-10 dígitos).', callback: i => { const v=(i.value||'').trim(); return !v || ext.test(v); } } } },
        phone_number_2:   { validators: { callback: { message: 'Formato E.164 inválido.', callback: i => { const v=(i.value||'').trim(); return !v || e164.test(v); } } } },
        phone_number_2_ext:{validators: { callback: { message: 'Extensión inválida (1-10 dígitos).', callback: i => { const v=(i.value||'').trim(); return !v || ext.test(v); } } } },
        email:            { validators: { emailAddress: { message: 'Correo inválido.' }, stringLength: { max: 254, message: 'Máx. 254 caracteres.' } } },
        hours_text:       { validators: { stringLength: { max: 120, message: 'Máx. 120 caracteres.' } } },
      }
    });
  });
</script>
@endpush
