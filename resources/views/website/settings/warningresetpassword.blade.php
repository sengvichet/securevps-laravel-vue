@extends('website.layouts.app')

@section('title', 'SHEV | איפוס סיסמה באמצעות אימייל')

@section('headercolor')
    <header class="alt-3 alt-3-short">
        @stop

        @section('content')
            <div class="center-form-box">
                    <h3>הודעה לאחר שליחת האימייל:</h3>
                    <p>הגעת למסך זה כיוון שלחצת על קישור לאיפוס סיסמה.
                        אם לא התכוונת לבצע איפוס סיסמה, לחץ על "ביטול".
 אם כן התכוונת לבצע איפוס סיסמה, לחץ על המשך ותתבקש להזין סיסמה חדשה.</p>
                <p>
                <form method="POST" action="{{ url('/password/setnewpass') }}" class="d-inline-block">
                    {{ csrf_field() }}
                    <input type="hidden" name="username" value="{{ session('setNewPassUsername') }}">
                    <button type="submit" class="button">המשך</button>
                </form>
                    <a href="{{ url('/') }}" class="button">ביטול</a>
                </p>
                <p>

                </p>
            </div>
@endsection
