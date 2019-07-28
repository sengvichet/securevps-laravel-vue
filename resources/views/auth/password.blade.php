@extends('website.layouts.app')

@section('title', 'SHEV | בחירת סיסמה')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
@include('website.includes.steps')

<div class="center-form-box">
    <form method="POST" action="{{ url('/register/setPassword') }}">
        {{ csrf_field() }}

        <h3>בחירת סיסמה - שלב 4</h3>

        <hr>

        <p>
            <label for="password">סיסמה</label>

            <input class="input-field" id="password" type="password" name="password">

            @if ($errors->has('password'))
                <div class="error-label">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </p>

        <p>
            <label for="password-confirm">אימות סיסמה</label>
            <input class="input-field" id="password-confirm" type="password" name="password_confirmation">
        </p>

        <hr>

        <p>
            <button type="submit" class="button large expanded">
                אישור
            </button>
        </p>
    </form>
</div>
@endsection
