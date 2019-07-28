@extends('website.layouts.app')

@section('title', 'SHEV | כניסה לחשבון מנהל מערכת')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="flex-login-container">
    <div class="center-form-box" id="app">
        <adminloginbysms></adminloginbysms>
    </div>

    <div class="center-form-box">
        <form method="POST" action="{{ url('/admin/login') }}">
            {{ csrf_field() }}
            <h3>כניסה לחשבון מנהל</h3>

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

            <p>
                <label for="smscode">הזן קוד SMS</label>

                <input class="input-field" id="smscode" type="text" name="smscode" value="{{ old('smscode') }}">
            </p>

            <hr>

            <p>
                <button type="submit" class="button large expanded">
                    כניסה
                </button>
            </p>
        </form>
    </div>
</div>
@endsection
