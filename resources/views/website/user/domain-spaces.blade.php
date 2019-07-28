@extends('website.layouts.app')

@section('title', 'SHEV | מרחבי דומיין')

@section('headercolor')
<header class="alt-3 alt-3-short">
@stop

@section('content')

<div class="row">
    @include('website.includes.user-nav')
</div>

<div id="app">
    <domainspaces></domainspaces>
</div>

{{--
<div class="login-container">

        <table id="tableDomainsList" class="table table-list">
            <thead>
                <tr>
                    <th width="20"></th>
                    <th>DOMAIN NAME</th>
                    <th>CP USER Name</th>
                    <th>RefToBePaid</th>
                    <th>Active</th>
                    <th>Mail</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($domains as $d)
                <tr onclick="clickableSafeRedirect(event, 'clientarea.php?action=domaindetails&amp;id={$domain.id}', false)">
                    <td>
                        <input type="checkbox" name="domids[]" class="domids stopEventBubble" value="{$domain.id}" />
                    </td>
                    <td><a href="http://{$domain.domain}" target="_blank">{{ $d['U_DOMAIN_NAME'] }}</a></td>
                    {{-- <td><span class="hidden">{$domain.normalisedRegistrationDate}</span>{$domain.registrationdate}</td>
                    <td><span class="hidden">{$domain.normalisedNextDueDate}</span>{$domain.nextduedate}</td> -- }}
                    <td>
                        {{ $d['U_CP_USER_Name'] }}
                        {{-- {if $domain.autorenew}
                            <i class="fa fa-fw fa-check text-success"></i> {$LANG.domainsautorenewenabled}
                        {else}
                            <i class="fa fa-fw fa-times text-danger"></i> {$LANG.domainsautorenewdisabled}
                        {/if} -- }}
                    </td>
                    <td>
                        {{-- {{ $d['U_Advance'] }} -- }}
                        {{ $d['U_Newslet'] }}
                        {{ $d['U_RefToBePaid'] }}
                        {{ $d['U_Active'] }}
                        {{-- {{ $d['U_Mail'] }} -- }}
                        {{ $d['U_DOMAIN_NAME'] }}
                        <span class="label status status-{{ $d['U_Active'] }}">{{ $d['U_Active'] }}</span>
                        <span class="hidden">
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="clientarea.php?action=domaindetailsid={$domain.id}" class="btn btn-default"><i class="fa fa-wrench"></i></a>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu text-left" role="menu">
                                {if $domain.status eq 'Active'}
                                    <li><a href="clientarea.php?action=domaindetailsid={$domain.id}#tabNameservers"><i class="glyphicon glyphicon-globe"></i> {$LANG.domainmanagens}</a></li>
                                    <li><a href="clientarea.php?action=domaincontactsdomainid={$domain.id}"><i class="glyphicon glyphicon-user"></i> {$LANG.domaincontactinfoedit}</a></li>
                                    <li><a href="clientarea.php?action=domaindetailsid={$domain.id}#tabAutorenew"><i class="glyphicon glyphicon-globe"></i> {$LANG.domainautorenewstatus}</a></li>
                                    <li class="divider"></li>
                                {/if}
                                <li><a href="clientarea.php?action=domaindetailsid={$domain.id}"><i class="glyphicon glyphicon-pencil"></i> {$LANG.managedomain}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="text-center" id="tableLoading">
            <p><i class="fa fa-spinner fa-spin"></i> {$LANG.loading}</p>
        </div>

</div>
--}}
@endsection
