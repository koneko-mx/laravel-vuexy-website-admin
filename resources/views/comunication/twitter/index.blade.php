@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Twitter API')

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
    @vite('vendor/koneko/laravel-vuexy-website-admin/resources/js/google-analytics-card-card.js')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            @livewire('vuexy-website-admin::twitter-card')
        </div>
    </div>
@endsection
