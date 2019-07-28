@extends('website.layouts.app')

@section('title', 'SHEV | איפוס סיסמה באמצעות אימייל')

@section('headercolor')
<header class="alt-3">
@stop

@section('msgaboveheader')
<!--  MESSAGES ABOVE HEADER IMAGE -->
<div class="message">
<div class="row">
<div class="small-12 columns">
<div class="message-intro">
<span class="message-line"></span>
<p>החשבון שלי</p>
<span class="message-line"></span>
</div>
<h1>שכחת סיסמה? אפס את סיסמתך</h1>
</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

<!-- Main Content -->
@section('content')
<div class="login-container">
    @if (session('status'))
        <div class="callout alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" class="login-form" action="{{ url('/password/email') }}">
        {{ csrf_field() }}
מה למחוק את זה?
        <p class="{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">אימייל</label>

            <input id="email" type="email" name="email" value="{{ old('email') }}">

            @if ($errors->has('email'))
                <span class="alert label">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </p>

        <p>
            <button type="submit" class="button">
                שלח לי מייל לאיפוס הסיסמה
            </button>
        </p>
    </form>
</div>
@endsection
