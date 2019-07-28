@extends('website.layouts.app')

@section('title', 'SHEV | פרטי משתמש')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
@include('website.includes.steps')

@if (! $firstStepDone)
<div class="center-form-box">
    <form method="POST" action="{{ url('/register') }}">
        {{ csrf_field() }}

        <h3>פרטי משתמש - שלב 1</h3>

        <hr>

        <p>
            <label for="first_name">שם פרטי</label>

            <input class="input-field" id="first_name" type="text" name="first_name" value="{{ old('first_name') }}">

            @if ($errors->has('first_name'))
                <div class="error-label">
                    {{ $errors->first('first_name') }}
                </div>
            @endif
        </p>

        <p>
            <label for="last_name">שם משפחה</label>

            <input class="input-field" id="last_name" type="text" name="last_name" value="{{ old('last_name') }}">

            @if ($errors->has('last_name'))
                <div class="error-label">
                    {{ $errors->first('last_name') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <label for="email">אימייל</label>

            <input class="input-field" id="email" type="email" name="email" value="{{ old('email') }}">

            @if ($errors->has('email'))
                <div class="error-label">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </p>

        <p>
            <label for="email_confirmation">אימייל הקש שנית</label>

            <input class="input-field" id="email_confirmation" type="email" name="email_confirmation" value="{{ old('email_confirmation') }}">

            @if ($errors->has('email_confirmation'))
                <div class="error-label">
                    {{ $errors->first('email_confirmation') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <label for="terms" class="remember-checkbox" style="width: 100%; font-size: 1em; text-align: center">
                <input class="checkbox-big" type="checkbox" name="terms" id="terms">
                אני מאשר את תנאי השימוש
            </label>
            <a id="termsPopup" style="margin: 10px auto; display: block; text-align: center;">&#x21A9; קרא את תנאי השימוש</a>
            @if ($errors->has('terms'))
                <div class="error-label">
                    {{ $errors->first('terms') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <button type="submit" class="button large expanded">
                הרשמה
            </button>
        </p>
    </form>
</div>

<div class="reveal-overlay reveal-overlay-terms" id="termPopupModal">
    <div class="reveal reveal-terms modal-scrollbar" title="גלגל עד למטה כדי לאשר">
        {!!html_entity_decode($terms)!!}
        <br />
        <br />
        <div class="text-center">
            <button type="button" class="button" id="termPopupModalClose" title="אני מאשר את תנאי השימוש">
                הבנתי את תנאי השימוש
            </button>
        </div>
    </div>
</div>
@endif

@if ($firstStepDone)
    <div class="center-form-box">
        <h3>הידד...</h3>
        <hr>
        <p>
            נרשמת בהצלחה למערכת, כעת גש בבקשה לתיבת האימייל שלך ולחץ על לינק האישור בכדי שנוכל לוודא את כתובת המייל שלך ולהמשיך בתהליך ההרשמה
        </p>
    </div>
@endif

@endsection
