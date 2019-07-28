@extends('website.layouts.app')

@section('title', 'SHEV | מספר טלפון נייד')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
@include('website.includes.steps')
<div class="center-form-box">
    <form method="POST" action="{{ url('/register/phone') }}">
        {{ csrf_field() }}

        <h3>מספר טלפון נייד - שלב 2</h3>

        <hr>

        <p>
            <label for="phone">הזן מספר סלולרי</label>

            <input class="input-field" id="phone" type="tel" name="phone" value="{{ old('phone') }}">

            @if ($errors->has('phone'))
                <div class="error-label">
                    {{ $errors->first('phone') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <button type="submit" class="button large expanded">
                שלח לי קוד SMS
            </button>
        </p>
    </form>
</div>
@endsection
