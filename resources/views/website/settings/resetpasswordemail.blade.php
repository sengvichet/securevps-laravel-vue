@extends('website.layouts.app')

@section('title', 'SHEV | איפוס סיסמה באמצעות אימייל')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
<div class="center-form-box">
    @if(Session::has('emailsent'))
        <h3>איפוס סיסמה באמצעות אימייל</h3>
        <p>
            <b>
                בקשת איפוס סיסמה נשלחה לכתובת האימייל שלך.
            </b>
        </p>
        <p>
            לחץ על הלינק המצורף באימייל כדי לאפס את הסיסמה
        </p>
        <p>
            שים לב שתוקף הלינק יפוג בעוד שעתיים מרגע זה,<br />
            בנוסף על כך הלינק תקף לאיפוס חד פעמי בלבד.
        </p>
        <p>
            <a href="{{ url('/login') }}" class="button">כניסה לחשבון שלי</a>
        </p>
    @else

        <form method="POST" action="{{ url('/password/accountslistresetbyemail') }}">
            {{ csrf_field() }}

            <h3>איפוס סיסמה באמצעות אימייל</h3>

            <hr>

            <p>
                <label for="email">אימייל</label>

                <input class="input-field" id="email" type="email" name="email" value="{{ old('email') }}"><br>

                @if ($errors->has('email'))
                    <div class="error-label">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </p>
            <div id="captcha"></div><br>
            @if ($errors->has('g-recaptcha-response'))
                <div class="error-label">
                    {{ $errors->first('g-recaptcha-response') }}
                </div>
            @endif
            <hr>
            <p>
                <button type="submit" class="button large expanded btn-captcha" disabled="disabled">
                    אישור
                </button>
            </p>
        </form>
    @endif
</div>
@endsection
