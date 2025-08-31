@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Sitios web')

@push('page-script')
    @vite('vendor/koneko/laravel-vuexy-admin/resources/assets/js/forms/formConvasHelper.js')
@endpush

@section('content')
    <div class="row g-6">
        @foreach ($sites as $site)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <x-vuexy-website-admin::websites.info-card-sm :site="$site" />
            </div>
        @endforeach

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <i class="ti ti-world text-7xl text-primary mt-1"></i>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <x-vuexy-admin::button.index-offcanvas :label="'Agregar sitio web'" :tagName="'WebsiteSite'" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('vuexy-website-admin::site.site-offcanvas-form')
@endsection
