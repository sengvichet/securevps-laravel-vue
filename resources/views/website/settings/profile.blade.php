@extends('website.layouts.app')

@section('title', 'SHEV | עריכת פרטי משתמש')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="row">
    @include('website.includes.user-nav')
</div>

<div class="center-form-box">
    <form method="POST" action="{{ url('/user/profile') }}">
        {{ csrf_field() }}
        <h3>פרטי משתמש</h3>

        <hr>

        <p>
            <label for="first_name">שם פרטי</label>

            <input class="input-field" id="first_name" type="text" name="first_name" value="{{ old('first_name', $user['first_name']) }}">

            @if ($errors->has('first_name'))
                <div class="error-label">
                    {{ $errors->first('first_name') }}
                </div>
            @endif
        </p>

        <p>
            <label for="last_name">שם משפחה</label>

            <input class="input-field" id="last_name" type="text" name="last_name" value="{{ old('last_name', $user['last_name']) }}">

            @if ($errors->has('last_name'))
                <div class="error-label">
                    {{ $errors->first('last_name') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <label for="email">אימייל</label>

            <input class="input-field" id="email" type="email" name="email" value="{{ old('email', $user['email']) }}">

            @if ($errors->has('email'))
                <div class="error-label">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </p>

        <p>
            <label for="second_email">אימייל נוסף</label>

            <input class="input-field" id="second_email" type="email" name="second_email" value="{{ old('second_email', $user['second_email']) }}">

            @if ($errors->has('second_email'))
                <div class="error-label">
                    {{ $errors->first('second_email') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <label for="phone">סלולרי</label>

            <input class="input-field" id="phone" type="tel" name="phone" value="{{ old('phone', $user['phone']) }}">

            @if ($errors->has('phone'))
                <div class="error-label">
                    {{ $errors->first('phone') }}
                </div>
            @endif
        </p>

        <p>
            <label for="second_phone">טלפון נוסף</label>

            <input class="input-field" id="second_phone" type="tel" name="second_phone" value="{{ old('second_phone', $user['second_phone']) }}">

            @if ($errors->has('second_phone'))
                <div class="error-label">
                    {{ $errors->first('second_phone') }}
                </div>
            @endif
        </p>

        <p>
            <label for="fax">פקס</label>

            <input class="input-field" id="fax" type="tel" name="fax" value="{{ old('fax', $user['fax']) }}">

            @if ($errors->has('fax'))
                <div class="error-label">
                    {{ $errors->first('fax') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <label for="company_name">חברה</label>

            <input class="input-field" id="company_name" type="text" name="company_name" value="{{ old('company_name', $user['company_name']) }}">

            @if ($errors->has('company_name'))
                <div class="error-label">
                    {{ $errors->first('company_name') }}
                </div>
            @endif
        </p>

        <p>
            <label for="company_number">מספר ח.פ./חברה</label>

            <input class="input-field" id="company_number" type="text" name="company_number" value="{{ old('company_number', $user['company_number']) }}">

            @if ($errors->has('company_number'))
                <div class="error-label">
                    {{ $errors->first('company_number') }}
                </div>
            @endif
        </p>

        <p>
            <label for="contact_person">איש קשר</label>

            <input class="input-field" id="contact_person" type="text" name="contact_person" value="{{ old('contact_person', $user['contact_person']) }}">

            @if ($errors->has('contact_person'))
                <div class="error-label">
                    {{ $errors->first('contact_person') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <label for="facebook">פייסבוק</label>

            <input class="input-field" id="facebook" type="text" name="facebook" value="{{ old('facebook', $user['facebook']) }}">

            @if ($errors->has('facebook'))
                <div class="error-label">
                    {{ $errors->first('facebook') }}
                </div>
            @endif
        </p>

        <hr>

        <p>
            <label for="street_address">רחוב</label>

            <input class="input-field" id="street_address" type="text" name="street_address" value="{{ old('street_address', $user['street_address']) }}">

            @if ($errors->has('street_address'))
                <div class="error-label">
                    {{ $errors->first('street_address') }}
                </div>
            @endif
        </p>

        <p>
            <label for="city">עיר</label>

            <input class="input-field" id="city" type="text" name="city" value="{{ old('city', $user['city']) }}">

            @if ($errors->has('city'))
                <div class="error-label">
                    {{ $errors->first('city') }}
                </div>
            @endif
        </p>

        <p>
            <label for="zip">מיקוד</label>

            <input class="input-field" id="zip" type="text" name="zip" value="{{ old('zip', $user['zip']) }}">

            @if ($errors->has('zip'))
                <div class="error-label">
                    {{ $errors->first('zip') }}
                </div>
            @endif
        </p>

        <p>
            <label for="state">מדינה state</label>

            <input class="input-field" id="state" type="text" name="state" value="{{ old('state', $user['state']) }}">

            @if ($errors->has('state'))
                <div class="error-label">
                    {{ $errors->first('state') }}
                </div>
            @endif
        </p>

        <p>
            <label for="country">מדינה country</label>

            <input class="input-field" id="country" type="text" name="country" value="{{ old('country', $user['country']) }}">

            @if ($errors->has('country'))
                <div class="error-label">
                    {{ $errors->first('country') }}
                </div>
            @endif
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
