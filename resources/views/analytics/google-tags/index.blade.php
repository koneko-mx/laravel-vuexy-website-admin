@extends('vuexy-admin::layouts.vuexy.layoutMaster')

@section('title', 'Google Tags')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @livewire('vuexy-website-admin::google-tags-card')
        </div>
    </div>
@endsection
