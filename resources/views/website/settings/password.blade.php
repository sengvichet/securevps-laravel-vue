@extends('website.layouts.app')

@section('title', 'SHEV | שינוי סיסמה')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="row">
    @include('website.includes.user-nav')
</div>

<div class="center-form-box">
    <form method="POST" action="{{ url('/password/change') }}">
        {{ csrf_field() }}
        <h3>החלפת סיסמה</h3>

        <hr>

        <p>
            <label for="current_password">סיסמה נוכחית</label>

            <input class="input-field" id="current_password" type="password" name="current_password">

            @if ($errors->has('current_password'))
                <div class="error-label">
                    {{ $errors->first('current_password') }}
                </div>
            @endif
        </p>
            <a class="" href="{{ url('/password/resetbyemailb') }}">
                שכחת את הסיסמה הנוכחית?
            </a>
        <hr>

        <p>
            <label for="password">סיסמה חדשה</label>

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

        <p class="submit-form-wrapper">
            <button type="button" onclick="window.history.back()" class="button hollow large expanded">
                ביטול
            </button>
            <button type="submit" class="button large expanded">
                אישור
            </button>
        </p>
    </form>
</div>

@endsection
