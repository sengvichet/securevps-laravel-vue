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
    בחר
    <div class="button-group">
        <a class="button submenu" href="{{ url('/user/invoices') }}">חשבוניות</a>
        <a class="button submenu active" href="{{ url('/user/receipts') }}">קבלות</a>
        <a class="button submenu" href="/user/credit-card">כרטיסי אשראי</a>
    </div>
</div>

<div id="app">
    <receipts />
</div>

@endsection
