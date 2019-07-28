@extends('website.layouts.app')

@section('title', 'SHEV | היסטוריית תשלומים')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="row">
    @include('website.includes.user-nav')
</div>

<div class="row">

</div>

<div id="app">
    <get-invoice-years></get-invoice-years>

    <invoices />
</div>

@endsection
