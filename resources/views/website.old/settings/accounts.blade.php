@extends('website.layouts.app')

@section('title', 'SHEV | רשימת חשבונות')

@section('headercolor')
    <header class="alt-3 alt-3-short">
        @stop

        @section('content')
            @if(isset($accounts) && !empty($accounts))
            <div class="login-container">
                <table class="table table-list">
                    <thead>
                    <tr>
                        <th>שם המשתמש</th>
                        <th>רשימת הדומיינים</th>
                        <th>איפוס</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <td>{{ $account['U_WEBSITE_USERNAME'] }}</td>
                            <td>
                                @if (count($account['U_DOMAIN_NAME']) == 1)
                                        {{ $account['U_DOMAIN_NAME'] }}
                                @elseif(count($account['U_DOMAIN_NAME']) > 1)
                                    @foreach ($account['U_DOMAIN_NAME'] as $domain)
                                        {{ $domain }}<br />
                                    @endforeach
                                @else
                                    אין דומיינים בחשבון הזה
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ url('/password/sendresetbyemailb') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="username" value="{{ $account['U_WEBSITE_USERNAME'] }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="firstname" value="{{ $account['U_CLIENT_FNAME'] }}">
                                    <button type="submit" class="button">איפוס סיסמה לחשבון</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @elseif(isset($accounts) && is_null($accounts))
                <div class="center-form-box">
                    <h3>הטוקן פג תוקף</h3>
                </div>
            @else
                @if(!empty($data))
                    <div class="login-container">
                        <table class="table table-list">
                            <thead>
                            <tr>
                                <th>שם המשתמש</th>
                                <th>רשימת הדומיינים</th>
                                <th>איפוס</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $account)
                                <tr>
                                    <td>{{ $account['U_WEBSITE_USERNAME'] }}</td>
                                    <td>
                                        @if (count($account['U_DOMAIN_NAME']) == 1)
                                            {{ $account['U_DOMAIN_NAME'] }}
                                        @elseif(count($account['U_DOMAIN_NAME']) > 1)
                                            @foreach ($account['U_DOMAIN_NAME'] as $domain)
                                                {{ $domain }}<br />
                                            @endforeach
                                        @else
                                            אין דומיינים בחשבון הזה
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ url('/password/setnewpass') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="username" value="{{ $account['U_WEBSITE_USERNAME'] }}">
                                            <button type="submit" class="button">איפוס סיסמה לחשבון</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="center-form-box">
                        <h3>מידע לא נמצא</h3>
                    </div>
                @endif
            @endif
@endsection
