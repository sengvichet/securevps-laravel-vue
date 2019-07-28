@extends('website.layouts.app')

@section('title', 'SHEV | עגלת קניות')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

@if($login !== NULL)
<div class="row">
    @include('website.includes.user-nav')
</div>
@endif

<div id="app">
    <cart></cart>
</div>
@endsection
