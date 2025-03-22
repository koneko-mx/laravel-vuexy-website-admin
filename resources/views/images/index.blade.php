@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Galería de Imágenes')

@push('page-script')
    @vite('vendor/koneko/laravel-vuexy-admin/resources/js/pages/admin-settings-scripts.js')
@endpush

@section('content')
    @livewire('vuexy-website-admin::images-index')
@endsection
