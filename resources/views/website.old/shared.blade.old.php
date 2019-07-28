@extends('website.layouts.app')

@section('title', 'SHEV | Shared Hosting')

@section('headercolor')
<header class="alt-1">
@stop

@section('msgaboveheader')
<!--  MESSAGES ABOVE HEADER IMAGE -->
<div class="message">
<div class="row">
<div class="small-12 columns">
<div class="message-intro">
<span class="message-line"></span>
<p>Shared Hosting</p>
<span class="message-line"></span>
</div>
<h1>AFFORDABLE WEB HOSTING PACKAGES</h1>
</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

@section('content')
<!--  PRCING BOXES COMPARISON  -->
<div class="pricingboxes-comparison">
<div class="row">
<div class="small-12 columns">
<h2>NO CONTRACT. MONTH-TO-MONTH.</h2>
<p>Stumptown fanny pack ullamco Neutra, Banksy keytar deep v four loko cray proident chillwave. Tote bag Brooklyn Bushwick pour-over. Helvetica shabby chic vegan stumptown. Occaecat yr seitan forage. Typewriter lo-fi sartorial, church-key hella est pickled sustainable master cleanse.</p>
</div>
</div>

<div class="spacing-30"></div>

<div class="row collapse">
<div data-wow-delay="0.2s"  class="small-12 large-3 medium-3 columns wow zoomIn hostingfeatures">
<div class="title-features">תכונות</div>
<ul class="pricing-table alter features">
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">שם</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">מערכת הפעלה</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">שטח דיסק</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">תעבורה חודשית</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">דומיינים</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">סאב דומיינים</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">בסיסי נתונים</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">חשבונות דואר</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">חשבונות FTP</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">99.99% זמינות</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">Pick your location</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">24x7 תמיכה טכנית</span></li>
<li class="bullet-item"><span data-tooltip aria-haspopup="true" class="has-tip left" data-disable-hover="false" title="Normcore PBR iPhone, typewriter fap dreamcatcher PBR XOXO artisan ">העברת אתר</span></li>
</ul>
</div>

<?php $wowEffectDelay = 0 ?>
@foreach ($sharedList as $shared)
<div data-wow-delay="{{ $wowEffectDelay += 0.2 }}s"  class="small-12 large-3 medium-3 columns wow zoomIn">
<div class="title-alt">{{ $shared['id'] }}</div>
<ul class="pricing-table alter">
<li class="bullet-item">{{ $shared['foreign_name'] }}</li>
<li class="bullet-item">{{ $shared['item_os'] }}</li>
<li class="bullet-item">{{ filterWebspace($shared['itemprops']['BasicWebspace']) }}</li>
<li class="bullet-item">{{ filterBandwidth($shared['itemprops']['BasicBandwidth']) }}</li>
<li class="bullet-item">{{ filterQty($shared['itemprops']['BasicDomain']) }}</li>
<li class="bullet-item">{{ filterQty($shared['itemprops']['BasicSubDomain']) }}</li>
<li class="bullet-item">{{ filterQty($shared['itemprops']['BasicDatabase']) }}</li>
<li class="bullet-item">{{ filterQty($shared['itemprops']['BasicEmail']) }}</li>
<li class="bullet-item">{{ filterQty($shared['itemprops']['BasicFTP']) }}</li>
<li class="bullet-item"><i class="fa fa-check"></i> <div class="show-for-small">24x7 Technical Support</div></li>
<li class="bullet-item"><i class="fa fa-times"></i> <div class="show-for-small">Pick your location</div></li>
<li class="bullet-item"><i class="fa fa-check"></i> <div class="show-for-small">24x7 Technical Support</div></li>
<li class="bullet-item"><i class="fa fa-times"></i> <div class="show-for-small">Free Website Transfer</div></li>
<li class="price"><strike>₪{{ (int) $shared['msrp'] }}</strike><span>₪{{ (int) $shared['price'] }}</span></li>
<li class="cta-button"><p><span><a href="{{ url('api/cart/add/' . $shared['id']) }}">הזמן חבילה</a></span></p></li>
</ul>
</div>
@endforeach

</div>
</div>
<!--  END OF PRCING BOXES COMPARISON  -->

<!--  SHARE HOSTING FEATURES  -->
<section class="sharedfeatures-odd wow fadeInUp">
<div class="row">
<div class="small-12 large-4 medium-4 columns">
<div class="circle"><i class="fa fa-globe"></i></div>
</div>
<div class="small-12 large-8 medium-8 columns">
<h2>THREE LOCATIONS WORLDWIDE</h2>
<p>Pitchfork occupy forage, try-hard Blue Bottle artisan Carles PBR typewriter banjo meh four loko fap. Butcher pork belly 90's, scenester raw denim crucifix you probably haven't heard of them kitsch beard cardigan lo-fi synth small batch. Kogi meh tattooed, YOLO Intelligentsia crucifix hoodie. Scenester Shoreditch mumblecore Intelligentsia DIY, 3 wolf moon beard. Chillwave distillery chambray, Neutra paleo fashion axe fixie. Irony XOXO farm-to-table fap narwhal, trust fund selfies put a bird on it Schlitz keffiyeh polaroid photo booth. </p>
</div>
</div>
</section>

<section class="sharedfeatures-even wow fadeInUp">
<div class="row">
<div class="small-12 large-8 medium-8 columns">
<h2>ONE-CLICK SOFTWARE INSTALLATIONS</h2>
<p>Pitchfork occupy forage, try-hard Blue Bottle artisan Carles PBR typewriter banjo meh four loko fap. Butcher pork belly 90's, scenester raw denim crucifix you probably haven't heard of them kitsch beard cardigan lo-fi synth small batch. Kogi meh tattooed, YOLO Intelligentsia crucifix hoodie. Scenester Shoreditch mumblecore Intelligentsia DIY, 3 wolf moon beard. Chillwave distillery chambray, Neutra paleo fashion axe fixie. Irony XOXO farm-to-table fap narwhal, trust fund selfies put a bird on it Schlitz keffiyeh polaroid photo booth. </p>
</div>
<div class="small-12 large-4 medium-4 columns">
<div class="circle"><i class="fa fa-random"></i></div>
</div>

</div>
</section>

<section class="sharedfeatures-odd wow fadeInUp">
<div class="row">
<div class="small-12 large-4 medium-4 columns">
<div class="circle"><i class="fa fa-thumbs-o-up"></i></div>
</div>
<div class="small-12 large-8 medium-8 columns">
<h2>24/7 SUPERB SUPPORT</h2>
<p>Pitchfork occupy forage, try-hard Blue Bottle artisan Carles PBR typewriter banjo meh four loko fap. Butcher pork belly 90's, scenester raw denim crucifix you probably haven't heard of them kitsch beard cardigan lo-fi synth small batch. Kogi meh tattooed, YOLO Intelligentsia crucifix hoodie. Scenester Shoreditch mumblecore Intelligentsia DIY, 3 wolf moon beard. Chillwave distillery chambray, Neutra paleo fashion axe fixie. Irony XOXO farm-to-table fap narwhal, trust fund selfies put a bird on it Schlitz keffiyeh polaroid photo booth. </p>
</div>
</div>
</section>

<section class="sharedfeatures-even wow fadeInUp">
<div class="row">
<div class="small-12 large-8 medium-8 columns">
<h2>SSD Drives</h2>
<p>Pitchfork occupy forage, try-hard Blue Bottle artisan Carles PBR typewriter banjo meh four loko fap. Butcher pork belly 90's, scenester raw denim crucifix you probably haven't heard of them kitsch beard cardigan lo-fi synth small batch. Kogi meh tattooed, YOLO Intelligentsia crucifix hoodie. Scenester Shoreditch mumblecore Intelligentsia DIY, 3 wolf moon beard. Chillwave distillery chambray, Neutra paleo fashion axe fixie. Irony XOXO farm-to-table fap narwhal, trust fund selfies put a bird on it Schlitz keffiyeh polaroid photo booth. </p>
</div>
<div class="small-12 large-4 medium-4 columns">
<div class="circle"><i class="fa fa-hdd-o"></i></div>
</div>

</div>
</section>
<!--  SHARE HOSTING FEATURES  -->
@stop
