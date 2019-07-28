@extends('website.layouts.app')

@section('title', 'SHEV | איפוס סיסמה באמצעות שם משתמש')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
<div class="center-form-box">
    <form method="POST" action="{{ url('/password/resetbyusername') }}">
        {{ csrf_field() }}

        <h3>איפוס סיסמה באמצעות שם משתמש</h3>

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

        <hr>

        <p>
            <button type="submit" class="button large expanded">
                אישור
            </button>
        </p>

        <hr>

        <p class="text-center">
            שכחת גם את שם המשתמש?
            <a class="" href="{{ url('/password/resetbyemailb') }}">
                לחץ כאן  לאיפוס סיסמה באמצעות אימייל
            </a>
        </p>
        <p class="text-center">
            {{--שכחת גם את האימייל? לחץ כאן לאיפוס סיסמה באמצעות SMS--}}
            שכחת גם את האימייל?
            <a class="" href="{{ url('/password/resetbysmsb') }}">
                לחץ כאן לאיפוס סיסמה באמצעות SMS
            </a>
        </p>
            {{--שכחת גם את האימייל? לחץ כאן לאיפוס סיסמה באמצעות SMS--}}
    </form>
</div>
@endsection
