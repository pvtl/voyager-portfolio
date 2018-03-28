@extends('voyager-frontend::layouts.default')
@section('meta_title', 'Portfolio')
@section('meta_description', 'Portfolio')
@section('page_title', 'Portfolio')

@section('content')
    @include('voyager-frontend::partials.page-title')

    <div class="vspace-2"></div>

    @include('voyager-frontend::modules.portfolio.posts-grid')
@endsection
