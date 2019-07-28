@extends('website.layouts.app')

@section('title', 'SHEV | אחסון שיתופי')

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
<p>אחסון אתרים שיתופיים</p>
<span class="message-line"></span>
</div>
<h1>חבילות אחסון אתרים שיתופיים - מוצר ותקציב נפגשים</h1>
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
<h2>חיובים על בסיס חודש בחודשו, ללא צורך בהתחייבות</h2>
<p>אחסון אתרים צריך להיות פשוט ומיידי. כמה שיותר מהר להנגיש את השירות עבור הלקוח.</p>
</div>
</div>

<div class="spacing-30"></div>

{{-- <div class="row collapse">
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
</div> --}}

{{--
@foreach ($sharedList as $shared)
<div data-wow-delay="{{ $wowEffectDelay += 0.2 }}s"  class="small-12 large-3 medium-3 columns wow zoomIn">
<div class="title-alt">{{ $shared['id'] }}</div>
<ul class="pricing-table alter">
<li class="bullet-item">{{ $shared['foreign_name'] }}</li>
<li class="bullet-item">{{ $shared['item_os'] }}</li>
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
@endforeach --}}

<!--  PRICING BOXES  -->
<div class="pricingboxes">
    <div class="row">
    <?php $wowEffectDelay = 0 ?>
    @foreach ($sharedList as $shared)
        <div data-wow-delay="{{ $wowEffectDelay += 0.1 }}s"  class="small-12 large-3 medium-3 columns wow fadeInUp" style="float:right">
            <div class="title">{{ $shared['foreign_name'] }}</div>
            <ul class="pricing-table">

                <li class="description"><strong>{{ $shared['description'] }}<br />{{ $shared['id'] }}</strong></li>
                <li class="bullet-item" style="font-size:22px">{{ $shared['item_os'] }}</li>

                <li class="bullet-item"><b style="font-size:18px">{{ filterWebspaceMB($shared['itemprops']['BasicWebspace']) }}</b> שטח דיסק</li>
                <li class="bullet-item"><b style="font-size:18px"> @if(isset($shared['itemprops']['BasicBandwidth'])) {{filterBandwidth($shared['itemprops']['BasicBandwidth'])}} @endif </b> תעבורה חודשית</li>

                <li class="price"><span>₪{{ (int) $shared['price'] }}</span>כולל מע"מ</li>
                <li class="cta-button"><p><span><a href="{{ url('api/cart/add/' . $shared['id']) }}">הזמן חבילה</a></span></p>
                </li>


                </li>
            </ul>
        </div>
    @endforeach
    </div>
</div>
<!--  END OF PRCING BOXES  -->


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
<h2>חוות השרתים בישראל ובחו"ל - חוויה גלובלית, שירות מקומי</h2>
<p>מרכז הפעילות שלנו הוא בחוות השרתים של סלקום (הידועה בעבר בשמות נטויז'ן ו-013),בפארק אפק ראש העין. מעבר לחוות השרתים הזו, אנו גם מטמיעים ב Amazon וב Goolge Cloud - הכול לפי הבקשה והצרכים של הלקוחות. </p>
</div>
</div>
</section>

<section class="sharedfeatures-even wow fadeInUp">
<div class="row">
<div class="small-12 large-8 medium-8 columns">
<h2>תוכנות ניהול שרתים ומערכות בילינג אוטומטיות מתקדמות</h2>
<p>אנחנו מטמיעים בכל שרתי האחסון האתרים השיתופיים לוחות בקרה וניהול כדוגמת  DirectAdmin ותוכנות התקנה שונות כ Installatron. כמו-כן, כל פעילות הלקוחות לרבות ההזמנות, חיובים והפקת החשבוניות והקבלות מתבצעים באונליין מיידית, ללא צורך בפניה לשירות הלקוחות. הורדת חשבוניות חתומות דיגיטלית בצורה עצמאית מיידית ומעקב  וצפייה בכל ההזמנות הקודמות. . </p>
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
<h2>תמיכת לקוחות מעולה 24/7</h2>
<p>כיום מובן כי תמיכה טכנית הינה חלק מהותי מהמוצר והשירות ואינם חלק נפרד. ב-SHEV.com אנחנו מבינים זאת היטב ולכן לקוחותינו מוזמנים ליצור איתנו קשר 24/7 364 ימים בשנה (נכון, ביום כיפור אנחנו לא זמינים). נבהיר כי אנו זמינים בטלפון ובאימייל כאשר אנחנו מחלקים את התמיכה שלנו לשתי הגדרות:  תמיכה תפעולית - שאלות שבדרך כלל מתחילות במילה "איך..?" ותמיכת חירום - שאלות שבדרך כלל מתחילות במילה "למה..?"
תמיכה תפעולית טלפונית זמינה בשעות הפעילות של 09:00 עד 18:00 כאשר אנחנו עדיין זמינים באימייל גם מעבר ל-18:00, אך בדיקת האימיילים בתדירות נמוכה לאחר 18:00. <br>
תמיכת חירום טלפונית זמינה 24/7.
</p>
</div>
</div>
</section>

<section class="sharedfeatures-even wow fadeInUp">
<div class="row">
<div class="small-12 large-8 medium-8 columns">
<h2>ההארד דיסקים הכי מהירים בשוק - SSD זמינים בשרתינו החדשים ביותר</h2>
<p>סדרת השרתים החדשה שלנו מגיעה עם ההארד דיסקים המהירים ביותר בשוק - SSD Enterprise Class SAS. אבל גם שאר השרתים האחרים שלנו מהירים מאד עם 15K RPM Enterprise Class SAS. בכל השרתים לא משנה איזה סוג ההארד דיסק, הביצועים הם אופטימליים באמצעות הגדרות RAID-5 או RAID-6 וכרטיסי RAID עם זיכרונות וסוללות גיבוי למערך ה-RAID עצמו.
עוד יובהר כי לעולם אנחנו לא מבצעים   Overselling - דהיינו - המשאבים הם 100% אמיתיים.

</p>
</div>
<div class="small-12 large-4 medium-4 columns">
<div class="circle"><i class="fa fa-hdd-o"></i></div>
</div>

</div>
</section>
<!--  SHARE HOSTING FEATURES  -->
@stop
