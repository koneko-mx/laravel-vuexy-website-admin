<div x-data="{}" wire:key="social-card-{{ $site->id }}">
    <x-vuexy-admin::form.card-form
      id="website-social-settings-card"
      title="Redes sociales"
      subtitle="Enlaces listos para tus templates (Navbar/Footer/Cards)"
      showActions
      wire:submit.prevent="save"
    >
      <div class="row">
        <div class="col-md-6">
          {{-- WhatsApp --}}
          <x-vuexy-admin::form.input model="whatsapp_phone" id="whatsapp_phone" label="WhatsApp (teléfono E.164)" icon="ti ti-brand-whatsapp" placeholder="+525512345678" autocomplete="off" />
          <x-vuexy-admin::form.input model="whatsapp_message" id="whatsapp_message" label="Saludo WhatsApp (opcional)" placeholder="Hola 👋, vengo de {site}…" autocomplete="off" />
          <div class="form-text">Macros: <code>{site}</code>, <code>{title}</code>, <code>{url}</code>. Se codifican en el enlace.</div>

          {{-- Facebook / Instagram / LinkedIn --}}
          <x-vuexy-admin::form.input model="facebook"  id="facebook"  label="Facebook"  icon="ti ti-brand-facebook"  placeholder="https://facebook.com/tu-pagina o @tu-pagina" />
          <x-vuexy-admin::form.input model="instagram" id="instagram" label="Instagram" icon="ti ti-brand-instagram" placeholder="https://instagram.com/tu-usuario o @tu-usuario" />
          <x-vuexy-admin::form.input model="linkedin"  id="linkedin"  label="LinkedIn"  icon="ti ti-brand-linkedin"  placeholder="https://linkedin.com/in/tu-usuario o @tu-usuario" />
        </div>

        <div class="col-md-6">
          {{-- X(Twitter) / TikTok --}}
          <x-vuexy-admin::form.input model="x_twitter" id="x_twitter" label="X (Twitter)" icon="ti ti-brand-twitter" placeholder="https://x.com/tu-usuario o @tu-usuario" />
          <x-vuexy-admin::form.input model="tiktok"    id="tiktok"    label="TikTok"     icon="ti ti-brand-tiktok"   placeholder="https://tiktok.com/@tu-usuario o @tu-usuario" />

          {{-- Google Business / Pinterest --}}
          <x-vuexy-admin::form.input model="google"    id="google"    label="Google"     icon="ti ti-brand-google"    placeholder="https://maps.app.goo.gl/... o perfil" />
          <x-vuexy-admin::form.input model="pinterest" id="pinterest" label="Pinterest"  icon="ti ti-brand-pinterest" placeholder="https://pinterest.com/tu-usuario o @tu-usuario" />

          {{-- YouTube / Vimeo --}}
          <x-vuexy-admin::form.input model="youtube"   id="youtube"   label="YouTube"    icon="ti ti-brand-youtube"   placeholder="https://youtube.com/@tu-usuario" />
          <x-vuexy-admin::form.input model="vimeo"     id="vimeo"     label="Vimeo"      icon="ti ti-brand-vimeo"     placeholder="https://vimeo.com/tu-usuario" />
        </div>
      </div>

      <div class="mt-2">
        <small class="text-muted">La tarjeta normaliza handles a URLs (ej. <code>@miusuario</code> → <code>https://instagram.com/miusuario</code>) y genera el enlace <code>wa.me</code> con tu saludo.</small>
      </div>
    </x-vuexy-admin::form.card-form>
</div>

@push('page-script')
<script>
    document.addEventListener('livewire:init', () => {
      const phonePattern = /^[+]?[1-9][0-9]{7,14}$/; // E.164

      window.SocialSettingsForm = new formCustomListener({
        formSelector:    '#website-social-settings-card',
        buttonSelectors: ['.btn-save', '.btn-cancel'],
        dispatchOnSubmit: 'save',
        // componentReload manejado por el listener v3 internamente por wire:id
        fieldsValidation: {
          whatsapp_phone: { validators: { callback: { message: 'Teléfono E.164. Ej: +525512345678.', callback: (i) => {
            const v = (i.value||'').trim(); if (!v) return true; return phonePattern.test(v); } } } },
          whatsapp_message: { validators: { stringLength: { max: 500, message: 'Máx 500 caracteres.' } } },
          facebook:  { validators: { uri: { message: 'URL inválida.' } } },
          instagram: { validators: { uri: { message: 'URL inválida.' } } },
          linkedin:  { validators: { uri: { message: 'URL inválida.' } } },
          tiktok:    { validators: { uri: { message: 'URL inválida.' } } },
          x_twitter: { validators: { uri: { message: 'URL inválida.' } } },
          google:    { validators: { uri: { message: 'URL inválida.' } } },
          pinterest: { validators: { uri: { message: 'URL inválida.' } } },
          youtube:   { validators: { uri: { message: 'URL inválida.' } } },
          vimeo:     { validators: { uri: { message: 'URL inválida.' } } },
        }
      });
    });
</script>
@endpush
