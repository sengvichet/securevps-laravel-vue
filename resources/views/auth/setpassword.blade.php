@extends('website.layouts.app')

@section('title', 'SHEV | הגדרת סיסמה חדשה')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
<div class="center-form-box">
    <form method="POST" action="{{ url('/password/storenewpass') }}">
        {{ csrf_field() }}

        <p>הגדר סיסמה חדשה עבור המשתמש: {{ $username }}</p>
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

        <p>
            <button type="submit" class="button large expanded">
                אישור
            </button>
        </p>
    </form>
</div>
@endsection
