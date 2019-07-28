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
                @elseif(Session::has('smssent'))
                    <h3>בוצעה שליחת הודעת SMS לטלפון שלך.</h3>
                    <form action="{{ url('/password/checksmscode') }}" method="post">
                        {{ csrf_field() }}
                        <p>
                            <label for="smscode">הזן קוד SMS שקיבלת</label>
                            <input id="smscode" type="text" placeholder="הזן קוד SMS כאן" name="smscode"  class="input-field">
                        @if ($errors->has('smscode'))
                            <div class="error-label">
                                {{ $errors->first('smscode') }}
                            </div>
                        @endif
                        </p>
                        <button type="submit" class="button large expanded">
                            אישור
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ url('/password/resetbysms') }}">
                        {{ csrf_field() }}

                        <h3>איפוס סיסמה באמצעות שליחת SMS</h3>

                        <hr>

                        <p>
                            <label for="phone"> מספר סלולרי</label>
                            <input id="phone" type="tel" placeholder=" מספר סלולרי" required="required" class="input-field" value="{{ old('phone') }}" name="phone">

                        @if ($errors->has('phone'))
                            <div class="error-label">
                                מספר הסלולרי חייב להיות בן 10 ל-13 ספרות
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
