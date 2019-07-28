@extends('website.layouts.app')

@section('title', 'SHEV | רשימת חשבונות')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')
<div class="login-container">
    <table class="table table-list">
        <thead>
            <tr>
                <th>שם המשתמש</th>
                <th>רשימת הדומיינים</th>
                <th>התחברות</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
            <tr>
                <td>{{ $account['U_WEBSITE_USERNAME'] }}</td>
                <td>
                    @if (!empty($account['U_DOMAIN_NAME']))
                        @foreach ($account['U_DOMAIN_NAME'] as $domain)
                            {{ $domain }}<br />
                        @endforeach
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ url('loginwithaccountname') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="username" value="{{ $account['U_WEBSITE_USERNAME'] }}">
                        <input type="hidden" name="bpcode" value="{{ $account['CardCode'] }}">
                        <input type="hidden" name="countDomains" value="{{ count($account['U_DOMAIN_NAME']) }}">
                        @if (!empty($account['U_DOMAIN_NAME']))
                                <input type="hidden" name="domainsCount" value="{{ count($account['U_DOMAIN_NAME'])}}">
                                <input type="hidden" name="domains" value="{{ json_encode($account['U_DOMAIN_NAME'])}}">
                        @endif
                        <button type="submit" class="button">
                            התחבר לחשבון
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
