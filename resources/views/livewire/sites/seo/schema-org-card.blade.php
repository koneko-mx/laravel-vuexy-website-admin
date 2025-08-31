<div
  x-data="{
    isSite: {{ $isSite ? 'true' : 'false' }},
    mode: @entangle('schema_mode').live,     // inherit|override|disable (Livewire <-> Alpine)
    get isEnabled(){ return this.mode === 'override' },
    get isInherit(){ return !this.isSite && this.mode === 'inherit' },
  }"
>
  <x-vuexy-admin::form.card-form
    id="website-schemaorg-card"
    class="form-custom-listener"
    title="Schema.org (JSON-LD)"
    subtitle="Marcado estructurado para SEO"
    linkHref="{{ $richResultsUrl }}"
    linkText="Probar en Rich Results"
    showActions
  >
    {{-- Selector de modo (cliente + Livewire) --}}
    <x-vuexy-website-admin::form.mode-toggle :is-site="$isSite" model="schema_mode" group="schema" class="mb-3" />

    {{-- Aviso cuando está heredando (solo Content) --}}
    <div class="alert alert-secondary py-2 mb-3 small" x-show="isInherit" x-cloak>
      Este contenido hereda el Schema del sitio. No hay campos editables aquí.
    </div>

    {{-- Editor SOLO si está habilitado --}}
    <fieldset :disabled="!isEnabled" x-show="isEnabled" x-cloak>
      <div class="row g-3 align-items-end">
        <div class="col-12 col-md-7">
          <x-vuexy-admin::form.select
            model="preset"
            label="Plantillas"
            :options="$presetOptions"
            placeholder="Selecciona un preset" />
        </div>
        <div class="col-12 col-md-5">
          <x-vuexy-admin::button.basic
            variant="secondary" size="sm" icon="ti ti-file-plus"
            class="mb-4 btn-insert-preset"
            label="Insertar plantilla"
            wire:click="applyPreset" />
        </div>
      </div>

      <label for="schema_org_text" class="form-label mt-2">JSON-LD</label>
      <x-vuexy-admin::form.textarea
        id="schema_org_text"
        name="schema_org_text"
        wire:model.defer="schema_org_text"
        class="font-monospace"
        style="min-height:260px"
        spellcheck="false" autocapitalize="off" autocomplete="off" autocorrect="off"
      >{{ $schema_org_text }}</x-vuexy-admin::form.textarea>

      <div class="mt-2 d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-schema-format">Formatear</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-schema-minify">Minificar</button>
        <button type="button" class="btn btn-sm btn-outline-danger"   id="btn-schema-clear">Limpiar</button>
      </div>

      <div class="alert alert-info py-2 mt-2">
        <div class="small">
          Incluye <code>@context</code> y <code>@type</code> (o usa <code>@graph</code>). Usa URLs absolutas.
        </div>
      </div>
    </fieldset>
  </x-vuexy-admin::form.card-form>
</div>

@push('page-script')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form   = document.getElementById('website-schemaorg-card');
    const ta     = document.getElementById('schema_org_text');
    const btnFmt = document.getElementById('btn-schema-format');
    const btnMin = document.getElementById('btn-schema-minify');
    const btnClr = document.getElementById('btn-schema-clear');

    function enableActions() {
      form.querySelectorAll('.btn-save, .btn-cancel').forEach(btn => {
        btn.disabled = false; btn.classList.remove('disabled');
      });
      if (window.SchemaorgCard?.markAsDirty) window.SchemaorgCard.markAsDirty();
      if (window.SchemaorgCard?.setDirty)    window.SchemaorgCard.setDirty(true);
    }
    function notifyChange() {
      ta.dispatchEvent(new Event('input',  { bubbles: true }));
      ta.dispatchEvent(new Event('change', { bubbles: true }));
      form.dispatchEvent(new Event('change', { bubbles: true }));
      enableActions();
    }
    function setValue(val) { ta.value = val ?? ''; notifyChange(); }

    btnFmt?.addEventListener('click', () => {
      const v = ta.value.trim(); if (!v) return;
      try { setValue(JSON.stringify(JSON.parse(v), null, 2)); }
      catch (e) { window.SchemaorgCard?.showError?.('schema_org_text', 'JSON inválido: ' + e.message); }
    });
    btnMin?.addEventListener('click', () => {
      const v = ta.value.trim(); if (!v) return setValue('');
      try { setValue(JSON.stringify(JSON.parse(v))); }
      catch (e) { window.SchemaorgCard?.showError?.('schema_org_text', 'JSON inválido: ' + e.message); }
    });
    btnClr?.addEventListener('click', () => setValue(''));

    window.SchemaorgCard = new formCustomListener({
      formSelector: '#website-schemaorg-card',
      buttonSelectors: ['.btn-save', '.btn-cancel'],
      dispatchOnSubmit: 'save',
      fieldsValidation: {
        schema_org_text: {
          validators: {
            callback: {
              message: 'JSON inválido',
              callback: function (input) {
                const raw = (input.value || '').trim();
                if (!raw) return true; // si quieres forzar requerido cuando override, valida en PHP
                try {
                  const obj = JSON.parse(raw);
                  if (!obj['@type'] && !obj['@graph']) {
                    return { valid:false, message:'Falta @type o @graph' };
                  }
                  return true;
                } catch (e) {
                  return { valid:false, message: e.message };
                }
              }
            }
          }
        }
      }
    });
  });
</script>
@endpush
