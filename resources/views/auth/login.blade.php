@extends('website.layouts.app')

@section('title', 'SHEV | כניסה לחשבון משתמש')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="flex-login-container">

    <div class="center-form-box"  id="form-for-login">
        <form method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <h3>כניסה לחשבון באמצעות סיסמה</h3>

            <hr>

            <p>
                <label for="username">שם משתמש</label>

                <input class="input-field" id="username" type="text" name="username" value="{{ old('username') }}">

                @if ($errors->has('username'))
                    <div class="error-label">
                        {{ $errors->first('username') }}
                    </div>
                @endif
            </p>

            <p>
                <label for="password">סיסמה</label>

                <input class="input-field" id="password" type="password" name="password">

                @if ($errors->has('password'))
                    <div class="error-label">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </p>

            <hr>

            <p>
                <button type="submit" class="button large expanded btn-login">
                    כניסה
                </button>
            </p>

            <hr>

            <p>
                לא מצליח להיכנס? לחץ:
                <a href="{{ url('/password/reset') }}">
                    איפוס סיסמה
                </a>
            </p>
        </form>
    </div>

    <div class="half-width-box-or">
        או
    </div>

    <div class="center-form-box in-row" id="app">
        <loginbysms></loginbysms>
        <validateloginsms></validateloginsms>
    </div>
</div>

@endsection
