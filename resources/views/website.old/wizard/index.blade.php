@extends('website.layouts.app')

@section('title', 'SHEV | אשף עדכון קונפיגורציה למוצר')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
<div id="app">
    <wizard cartid="{{ $cartid }}"></wizard>
</div>
@endsection
