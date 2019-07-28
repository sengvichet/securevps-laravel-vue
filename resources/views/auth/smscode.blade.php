@extends('website.layouts.app')

@section('title', 'SHEV | הזן קוד SMS')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
@include('website.includes.steps')
<div class="center-form-box">
    <form method="POST" action="{{ url('/register/smscode') }}">
        {{ csrf_field() }}

        <h3>הזן קוד SMS - שלב 3</h3>

        <hr>

        <p>
            <label for="smscode">הזן קוד SMS שקיבלת</label>

            <input class="input-field" id="smscode" type="text" name="smscode" value="{{ old('smscode') }}">

            @if ($errors->has('smscode'))
                <div class="error-label">
                    {{ $errors->first('smscode') }}
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

        <p>
            לא קיבלת SMS? אולי טעית בהקשת מספר הטלפון שלך?<br />
            <a href="{{ url('register/phone') }}">לחץ כאן כדי לשלוח שוב</a>
        </p>
    </form>
</div>
@endsection
