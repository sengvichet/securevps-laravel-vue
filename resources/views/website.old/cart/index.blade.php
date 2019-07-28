@extends('website.layouts.app')

@section('title', 'SHEV | עגלת קניות')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
<div class="row">
    @include('website.includes.user-nav')
</div>

<div id="app">
    <cart></cart>
</div>
@endsection
