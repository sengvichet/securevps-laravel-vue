@extends('website.layouts.app')

@section('title', 'SHEV | רשימת חשבונות')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="row">
    @include('website.includes.admin-nav')
</div>

<div id="app">
    <users></users>
</div>

@endsection
