@extends('website.layouts.app')

@section('title', 'SHEV | רשימת חשבונות')

@section('headercolor')
    <header class="alt-3 alt-3-short">
        @stop

        @section('content')
            <div class="center-form-box">
                <h3>איפוס באמצעות אימייל או SMS ?</h3><br>
                <form method="POST" action="{{ url('/password/resetpasswordmethod') }}">
                    {{ csrf_field() }}
                    <input type="radio" id="email" name="method" value="email" checked="checked">
                    <label for="email">איפוס באמצעות אימייל</label><br>
                    <input type="radio" id="sms" name="method" value="sms">
                    <label for="sms">איפוס באמצעות SMS</label><br>
                    <div id="captcha"></div><br>
                    @if ($errors->has('g-recaptcha-response'))
                        <div class="error-label">
                            {{ $errors->first('g-recaptcha-response') }}
                        </div>
                    @endif
                    <input type="hidden" value="{{ $username }}" name="username"><br>
                    <button class="button btn-captcha" type="submit" disabled = "disabled">אישור</button>
                </form>
            </div>
@endsection
