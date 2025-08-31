@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Sitio web: ' . $site->domain)

@section('content')
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-3">
            <x-vuexy-website-admin::websites.sidebar-edit :site="$site" :active="$tab" />
        </div>
        <div class="col-xl-10 col-lg-10 col-md-9">
            @include("vuexy-website-admin::sites.site.$tab")
        </div>
    </div>
@endsection
