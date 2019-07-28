@extends('website.layouts.app')

@section('title', 'SHEV | Domain Names')

@section('headercolor')
<header class="alt-4">
@stop

@section('msgaboveheader')
<!--  MESSAGES ABOVE HEADER IMAGE -->
<div class="message">
<div class="row">
<div class="small-12 columns">
<div class="message-intro">
<span class="message-line"></span>
<p>Domain Names</p>
<span class="message-line"></span>
</div>
<h1>ALL DOMAINS. ONE REGISTRAR.</h1>

<!-- DOMAIN NAME SEARCH BOX -->

 <div class="domainsearch">
    <div class="row collapse">
    <div class="small-12 large-10 medium-10 large-centered medium-centered columns">

     <form method="post">
    <div class="row collapse">
      <div class="small-12 large-8 medium-8 columns">
        <input type="text" name="sld" onfocus="if (this.value == 'Enter your domain') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Enter your domain';}" value="Enter your domain"/>
      </div>
      <div class="small-12 large-2 medium-2 columns">
      <select name="tld">
      <option>.com</option>
      <option>.net</option>
      <option>.org</option>
      <option>.eu</option>
    </select>
     </div>
      <div class="small-12 large-2 medium-2 columns">
        <input class="btn-wide" type="submit" value="Search" name="submit">
      </div>
</div>
</form>

</div>
</div>
</div>
<!-- END OF DOMAIN NAME SEARCH BOX -->


</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

@section('content')
<!-- DOMAIN PRICES  -->
<div class="domain-prices">
<div class="row">
<div class="small-12 columns">
<h2>BEST PRICES FOR ALL gTLDs AND ccTLDs</h2>
<p>Stumptown fanny pack ullamco Neutra, Banksy keytar deep v four loko cray proident chillwave. Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>


<!--  PRCING BOXES COMPARISON  -->
<div class="spacing-30"></div>

<div class="row collapse">
<div class="small-3 columns">
<div class="title-features">TLD</div>
<ul class="pricing-table domains tld">
<li class="bullet-item">.COM</li>
<li class="bullet-item">.NET</li>
<li class="bullet-item">.ORG</li>
<li class="bullet-item">.EU</li>
<li class="bullet-item">.CLUB</li>
<li class="bullet-item">.XYZ</li>
<li class="bullet-item">.AERO</li>
<li class="bullet-item">.CARE</li>
<li class="bullet-item">.TV</li>
<li class="bullet-item">.CRUISES</li>
</ul>
</div>

<div class="small-3 columns">
<div class="title-alt">REGISTER</div>
<ul class="pricing-table domains">
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$10.39</li>
<li class="bullet-item">$14.09</li>
<li class="bullet-item">$10.39</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
</ul>
</div>

<div class="small-3 columns">
<div class="title-alt">RENEW</div>
<ul class="pricing-table domains">
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$10.39</li>
<li class="bullet-item">$14.09</li>
<li class="bullet-item">$10.39</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
</ul>
</div>

<div class="small-3 columns">
<div class="title-alt">TRANSFER</div>
<ul class="pricing-table domains">
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$9.99</li>
<li class="bullet-item">$10.39</li>
<li class="bullet-item">$14.09</li>
<li class="bullet-item">$10.39</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
<li class="bullet-item">$38.99</li>
</ul>

</div>
<p class="text-center">All pricing is per year and in US dollars</p>

</div>
</div>
</div>
</div>
<!--  END OF PRCING BOXES COMPARISON  -->


<div class="domainfeatures-list">
<div class="row">
<div class="small-12 columns">
<!-- DOMAIN FEATURES   -->
<ul class="small-block-grid-1 large-block-grid-2 medium-block-grid-2 domainfeatures">

<li  data-wow-delay="0.1s" class="wow zoomIn">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<div class="circle"><i class="fa fa-repeat"></i></div>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>API integration</h3>
<p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial.</p>
</div>
</div>
</li>

<li  data-wow-delay="0.2s" class="wow zoomIn">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<div class="circle"><i class="fa fa-plus-circle"></i></div>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>Free Add-Ons</h3>
<p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial.</p>
</div>
</div>
</li>

<li  data-wow-delay="0.3s" class="wow zoomIn">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<div class="circle"><i class="fa fa-list-alt"></i></div>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>Easy to use Control Panel</h3>
<p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial.</p>
</div>
</div>
</li>

<li  data-wow-delay="0.4s" class="wow zoomIn">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<div class="circle"><i class="fa fa-cog"></i></div>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>DNS Management</h3>
<p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial.</p>
</div>
</div>
</li>

<li  data-wow-delay="0.5s" class="wow zoomIn">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<div class="circle"><i class="fa fa-lock"></i></div>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>Domain Locking</h3>
<p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial.</p>
</div>
</div>
</li>

<li  data-wow-delay="0.6s" class="wow zoomIn">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<div class="circle"><i class="fa fa-usd"></i></div>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>Domain Reseller Program</h3>
<p>Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial.</p>
</div>
</div>
</li>

</ul>
</div>
</div>
</div>
<!--  END OF DOMAIN FEATURES  -->
@stop
