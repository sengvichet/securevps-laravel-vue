@extends('website.layouts.app')

@section('title', 'SHEV | רשימת חשבונות')

@section('headercolor')
    <header class="alt-3 alt-3-short">
        @stop

        @section('content')
            <div class="center-form-box">
                <h3>שם המשתמש שהזנת לאיפוס לא נמצא במערכת.</h3><br>
                <p>האם תרצה לנסות לאתר ולאפס את חשבונך באמצעות אימייל או שליחת SMS?</p><br>
                <p>
                    שכחת גם את שם המשתמש?
                    <a class="" href="{{ url('/password/resetbyemailb') }}">
                        לחץ כאן  לאיפוס סיסמה באמצעות אימייל
                    </a>
                </p>
                <p>
                    {{--שכחת גם את האימייל? לחץ כאן לאיפוס סיסמה באמצעות SMS--}}
                    שכחת גם את האימייל?
                    <a class="" href="{{ url('/password/resetbysmsb') }}">
                        לחץ כאן לאיפוס סיסמה באמצעות SMS
                    </a>
                </p>
            </div>
@endsection
