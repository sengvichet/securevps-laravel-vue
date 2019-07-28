@extends('website.layouts.app')

@section('title', 'SHEV | תקנון החברה ותנאי שימוש')

@section('headercolor')
<header class="alt-2">
@stop

@section('msgaboveheader')
<!--  MESSAGES ABOVE HEADER IMAGE -->
<div class="message">
<div class="row">
<div class="small-12 columns">
<div class="message-intro">
<span class="message-line"></span>
<p>תקנון החברה</p>
<span class="message-line"></span>
</div>
<h1>תנאי שימוש בשירותי האחסון שלנו</h1>
</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

@section('content')
<div class="row">
    {!!html_entity_decode($text)!!}
    <br />
    <br />
</div>
<!-- END OF CONTENT -->
@stop
