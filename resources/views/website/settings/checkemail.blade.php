@extends('website.layouts.app')

@section('title', 'SHEV | רשימת חשבונות')

@section('headercolor')
    <header class="alt-3 alt-3-short">
        @stop

        @section('content')
                <div class="center-form-box">
                    <h3>בקשתך לאיפוס סיסמה באמצעות אימייל לכתובת:  {{ $email }}
                        התקבלה. במידה והאימייל שהזנת נמצא אצלנו במערכת, הוא יקבל הודעה לאיפוס הסיסמה. נא בדוק את תיבת האימייל שלך.</h3>
                </div>
@endsection
