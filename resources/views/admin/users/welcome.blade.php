@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Welcome') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Welcome') . ' ' . auth()->user()->name }}</h1>
@endsection

@section('custom-js')

@endsection

