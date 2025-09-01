<div>
    <x-vuexy-admin::form.card-form
        id="website-schemaorg-card"
        title="Schema.org (JSON-LD)"
        subtitle="Marcado estructurado para SEO"
        linkHref="{{ $richResultsUrl }}"
        linkText="Probar en Rich Results"
        showActions
    >
        {{-- Selector de modo --}}
        <x-vuexy-website-admin::form.mode-toggle
            :is-site="$isSite"
            model="schema_mode"
            group="schema"
            :value="$schema_mode"
            {{-- el contenedor padre define dónde togglear --}}
            data-scope="#website-schemaorg-card"
            data-show-when-override=".display-enable"
            data-show-when-inherit=".display-inherit"
        />

        {{-- Aviso cuando está heredando (solo Content) --}}
        <div class="display-inherit {{ $schema_mode === 'inherit' ? '' : 'd-none' }}">
            <div class="alert alert-secondary py-2 mb-3 small">
                Este contenido hereda el Schema del sitio. No hay campos editables aquí.
            </div>
        </div>

        {{-- Editor SOLO si está habilitado --}}
        <div class="display-enable {{ $schema_mode === 'override' ? '' : 'd-none' }}">
            <fieldset {{ $schema_mode === 'override' ? '' : 'disabled' }}>
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
                    model="schema_org_text"
                    class="font-monospace"
                    style="min-height:260px"
                    spellcheck="false" autocapitalize="off" autocomplete="off" autocorrect="off"
                    :value="$schema_org_text" />

                <div class="mt-2 d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-schema-format">Formatear</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-schema-minify">Minificar</button>
                    <button type="button" class="btn btn-sm btn-outline-danger"    id="btn-schema-clear">Limpiar</button>
                </div>

                <div class="alert alert-info py-2 mt-2">
                    <div class="small">
                        Incluye <code>@context</code> y <code>@type</code> (o usa <code>@graph</code>). Usa URLs absolutas.
                    </div>
                </div>
            </fieldset>
        </div>
    </x-vuexy-admin::form.card-form>
</div>

@push('page-script')
    <script>
        (function () {
            /* ==============================
            * Utils
            * ============================== */
            const $  = (sel, root = document) => root.querySelector(sel);
            const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

            /* =========================================================
            * ModeToggle: muestra/oculta secciones según el modo elegido
            * Requisitos del HTML (salen de tu Blade mode-toggle):
            *  - Contenedor con id terminado en "-group"
            *  - data-hidden="#id-del-hidden" (si usas hidden con wire:model.defer)
            *  - data-scope / data-show-when-override / data-show-when-inherit (opcional)
            * ========================================================= */
            const ModeToggle = {
                apply(groupEl) {
                    if (!groupEl) return;
                    const scopeSel = groupEl.dataset.scope || '';
                    const scope = scopeSel ? $(scopeSel) : groupEl.closest('form') || document;
                    const mode = groupEl.querySelector('.btn-check[type="radio"]:checked')?.value;

                    const show = (selector, yes) => {
                        if (!selector) return;
                        $$(selector, scope).forEach(el => {
                            el.classList.toggle('d-none', !yes);

                            // Deshabilita fields visibles/invisibles con criterio
                            const fieldsets = el.matches('fieldset') ? [el] : $$('fieldset', el);
                            if (fieldsets.length) {
                                fieldsets.forEach(fs => fs.disabled = !yes);
                            } else {
                                $$('input,select,textarea,button', el).forEach(i => i.disabled = !yes);
                            }
                        });
                    };

                    show(groupEl.dataset.showWhenOverride, mode === 'override');
                    show(groupEl.dataset.showWhenInherit,  mode === 'inherit');
                    show(groupEl.dataset.showWhenDisable,  mode === 'disable');
                },

                initAll() {
                    $$('[id$="-group"][data-hidden]').forEach(el => this.apply(el));
                },

                // Delegación global: radio -> hidden (wire:model.defer) + re-aplicar UI
                onRadioChange(ev) {
                    const r = ev.target;
                    if (!r.matches('.btn-check[type="radio"]')) return;
                    const groupEl = r.closest('[id$="-group"][data-hidden]');
                    if (!groupEl) return;

                    // Refleja en hidden (si existe) para Livewire (defer => no AJAX inmediato)
                    const hidden = $(groupEl.dataset.hidden);
                    if (hidden) {
                        hidden.value = r.value;
                        hidden.dispatchEvent(new Event('input', { bubbles: true })); // marca dirty
                    }

                    // Actualiza UI
                    ModeToggle.apply(groupEl);

                    // Habilita botones del form si usas tu listener
                    const form = groupEl.closest('form');
                    form?.dispatchEvent(new Event('change', { bubbles: true }));
                },

                mount() {
                    document.addEventListener('change', this.onRadioChange);

                    // Primera pasada
                    document.addEventListener('DOMContentLoaded', () => this.initAll());

                    // Livewire v3: re-aplica tras cada morph/update
                    document.addEventListener('livewire:init', () => {
                        const re = () => this.initAll();
                        Livewire.hook('morph.updated', re);
                        Livewire.hook('commit',        re);
                        Livewire.hook('message.failed',re);
                    });
                }
            };

            /* =========================================================
            * SchemaEditor: acciones del JSON-LD + formCustomListener
            * ========================================================= */
            const SchemaEditor = {
                formId: '#website-schemaorg-card',

                enableActions(form) {
                    $$('.btn-save, .btn-cancel', form).forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('disabled');
                    });
                    if (window.SchemaorgCard?.markAsDirty) window.SchemaorgCard.markAsDirty();
                    if (window.SchemaorgCard?.setDirty)    window.SchemaorgCard.setDirty(true);
                },

                notifyChange(form, ta) {
                    ta.dispatchEvent(new Event('input',  { bubbles: true }));
                    ta.dispatchEvent(new Event('change', { bubbles: true }));
                    form.dispatchEvent(new Event('change', { bubbles: true }));
                    this.enableActions(form);
                },

                bindButtons(form) {
                    const ta     = $('#schema_org_text', form);
                    const btnFmt = $('#btn-schema-format', form);
                    const btnMin = $('#btn-schema-minify', form);
                    const btnClr = $('#btn-schema-clear',  form);
                    if (!ta) return;

                    const setValue = (val) => { ta.value = val ?? ''; this.notifyChange(form, ta); };

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
                },

                mountOnce() {
                    const form = $(this.formId);
                    if (!form || form.dataset.schemaInit === '1') return;
                    form.dataset.schemaInit = '1';

                    // Botones/textarea
                    this.bindButtons(form);

                    // Tu listener de formulario
                    window.SchemaorgCard = new formCustomListener({
                        formSelector: this.formId,
                        buttonSelectors: ['.btn-save', '.btn-cancel'],
                        dispatchOnSubmit: 'save',
                        fieldsValidation: {
                            schema_org_text: {
                                validators: {
                                    callback: {
                                        message: 'JSON inválido',
                                        callback: (input) => {
                                            const raw = (input.value || '').trim();
                                            if (!raw) return true; // si quieres requerirlo en override, valida en PHP
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
                },

                mount() {
                    document.addEventListener('DOMContentLoaded', () => this.mountOnce());
                    document.addEventListener('livewire:init', () => {
                        const re = () => this.mountOnce();
                        Livewire.hook('morph.updated', re);
                        Livewire.hook('commit',        re);
                        Livewire.hook('message.failed',re);
                    });
                }
            };

            /* ==============================
            * Arranque
            * ============================== */
            ModeToggle.mount();
            SchemaEditor.mount();
        })();
    </script>
@endpush
