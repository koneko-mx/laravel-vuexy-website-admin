<div>
    <x-vuexy-admin::form.card-form
      id="website-seo-location-card"
      title="Idioma y Geolocalización"
      subtitle="Idioma y geo"
      showActions
      wire:submit.prevent="save"
    >
        <x-vuexy-admin::form.select model="locale" label="Idioma" :options="['es-MX'=>'Español (MX)','es-ES'=>'Español (ES)','en-US'=>'English (US)']" />
    </x-vuexy-admin::form.card-form>
</div>

@push('page-script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Inicializar formularios de Visibilidad y seguridad
            window.VisibilitySecuritySettingsForm = new formCustomListener({
                formSelector: '#website-seo-location-card',
                buttonSelectors: ['.btn-save', '.btn-cancel'],
            });

        });
    </script>
@endpush
