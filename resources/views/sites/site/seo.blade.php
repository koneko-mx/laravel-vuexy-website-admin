@section('vendor-style')
    @vite('vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/form-validation.scss')
@endsection

@section('vendor-script')
    @vite([
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/popular.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/js/forms/formCustomListener.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/js/notifications/LivewireNotification.js',
    ])
@endsection

<x-vuexy-admin::media.image-processor-scripts />
<x-vuexy-website-admin::form.mode-toggle-script />

<div class="row">
    <div class="col-6">
        @livewire('vuexy-website-admin::site.schema-org-card', ['seoableType' => 'site', 'seoableId' => $site->id])`
    </div>
    <div class="col-6">
        @livewire('vuexy-website-admin::site.local-location-card', ['site' => $site])
    </div>
</div>
<div class="row">
    <div class="col-10">
        @livewire('vuexy-website-admin::site.og-card', ['seoableType' => 'site', 'seoableId' => $site->id])
    </div>
    <div class="col-10">
        @livewire('vuexy-website-admin::site.twitter-card', ['seoableType' => 'site', 'seoableId' => $site->id])
    </div>
</div>

