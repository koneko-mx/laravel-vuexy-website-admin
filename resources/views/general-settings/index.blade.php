@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Ajustes Generales')

@push('page-script')
    @vite('vendor/koneko/laravel-vuexy-admin/resources/js/pages/admin-settings-scripts.js')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @livewire('vuexy-website-admin::website-description-settings')
            @livewire('vuexy-website-admin::website-favicon-settings')
        </div>
        <div class="col-lg-4">
            @livewire('vuexy-website-admin::logo-on-light-bg-settings')
            @livewire('vuexy-website-admin::logo-on-dark-bg-settings')
        </div>
    </div>
@endsection
