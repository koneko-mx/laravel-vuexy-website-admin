@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Whatsapp Chat')

@section('vendor-style')
    @vite([
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/form-validation.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/popular.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'vendor/koneko/laravel-vuexy-admin/resources/assets/vendor/libs/@form-validation/auto-focus.js',
    ])
@endsection

@push('page-script')
    @vite('vendor/koneko/laravel-vuexy-website-admin/resources/js/chat-settings-card.js')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            @livewire('vuexy-website-admin::whatsapp-card')
        </div>
    </div>
@endsection
