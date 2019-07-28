@extends('website.layouts.app')

@section('title', 'SHEV | רשימת משתמשים מקומיים')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="row">
    @include('website.includes.admin-nav')
</div>

<div id="app">
    <local-users></local-users>
</div>

@endsection
