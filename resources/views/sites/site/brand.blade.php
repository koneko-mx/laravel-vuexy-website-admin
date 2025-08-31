@section('vendor-style')
    @vite('vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/form-validation.scss')
@endsection

@section('vendor-script')
    @vite([
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/popular.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/js/forms/formCustomListener.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/js/livewire/registerLivewireHookOnce.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/js/notifications/LivewireNotification.js',
    ])
@endsection

<div class="row">
    <div class="col-6">
        @livewire('vuexy-website-admin::site.brand-card', ['site' => $site])

        @livewire('vuexy-website-admin::site.logo-on-dark-bg-card', ['site' => $site])
    </div>
    <div class="col-6">
        @livewire('vuexy-website-admin::site.logo-on-light-bg-card', ['site' => $site])
    </div>
</div>
