@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Google Search Console')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @livewire('vuexy-website-admin::google-search-console-card')
        </div>
    </div>
@endsection
