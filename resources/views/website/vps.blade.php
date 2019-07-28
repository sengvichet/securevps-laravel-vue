@extends('website.layouts.app')

@section('title', 'SHEV | VPS')

@section('headercolor')
<header class="alt-3">
@stop

@section('msgaboveheader')
<!--  MESSAGES ABOVE HEADER IMAGE -->
<div class="message">
<div class="row">
<div class="small-12 columns">
<div class="message-intro">
<span class="message-line"></span>
<p>ענן VPS</p>
<span class="message-line"></span>
</div>
<h1>הפעל בתוך דקות, און-ליין 24/7</h1>
</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

@section('content')
<!--  ORDER STEPS  -->
<div class="vps-order-steps">
<div class="row">
<div class="small-12 columns">
<h2>התחלה בקלי קלות.</h2>
<p>מעונן חלקית עד בהיר. אז זהו, שאנחנו לא עוסקים במזג אויר. ענייננו הוא בצד הטכני. שרתים, מערכות הפעלה  ואחסון אתרים. שרת וירטואלי הוא למעשה מונח הבסיס למה שמכונה ענן באינטרנט. SHEV.com  מספקת שרתים וירטואליים וסביבות פיתוח מגוונות בחוות השרתים עם אפשרויות הגדלת משאבים דינמיות לפי הצורך (Ad-hoc).
ניתן להתחיל ב-VPS קטן, ובאמצעות אשף ההזמנות, להגדיל (או להקטין) משאבים בצורה דינמית בכל עת ולהיות מחוייבים רק על פי המשאבים המוזמנים לעת הנדרשת.</p>

<div class="spacing-top-50"></div>

    <div class="row">
        <div data-wow-delay="0.2s"  class="large-4 medium-4 columns text-center wow zoomIn hide-for-small-only">
            <img src="images/icons/vps_step_1.png" alt=""/>
        </div>
        <div data-wow-delay="0.4s" class="large-4 medium-4 columns text-center wow zoomIn hide-for-small-only">
            <img src="images/icons/vps_step_2.png" alt=""/>
        </div>
        <div data-wow-delay="0.6s" class="large-4 medium-4 columns text-center wow zoomIn hide-for-small-only">
            <img src="images/icons/vps_step_3.png" alt=""/>
        </div>
        <div class="large-12 columns hide-for-small-only">
            <div class="order-step">
                <div class="row collapse">
                    <div data-wow-delay="0.2s" class="order-circle large-4 medium-4 columns wow fadeInUp">
                        <div class="line left-side"></div>
                        <span class="left-side">1</span>
                    </div>
                    <div data-wow-delay="0.4s" class="order-circle large-4 medium-4 columns wow fadeInUp">
                        <div class="line"></div>
                        <span>2</span>
                    </div>
                    <div data-wow-delay="0.6s" class="order-circle large-4 medium-4 columns wow fadeInUp">
                        <div class="line right-side"></div>
                        <span class="right-side">3</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-4 medium-4 small-12 columns text-center">
            <img class="show-for-small-only" src="images/icons/vps_step_1.png" alt="" />
            <h3>בחר תוכנית ענן VPS</h3>
            <p>בחר את שרת ה-VPS התואם את הגדרות ההתחלה שלך, אם אינך בטוח באיזה לבחור, בחר בשרת הקטן ביותר, כי תמיד תוכל לשדרג.</p>
        </div>
        <div class="large-4 medium-4 small-12 columns text-center">
            <img class="show-for-small-only" src="images/icons/vps_step_2.png" alt=""/>
            <h3>צור חשבון משתמש</h3>
            <p>לאחר בחירת ה-VPS שמתאים לך, אם לא יצרת חשבון משתמש קודם, הינך מתבקש ליצור חשבון משתמש. הקמת החשבון היא מהירה וקלה ומאפשרת התחברות מאובטחת עם שמירה מקסימלית של פרטיך ופרטיותך.</p>
        </div>
        <div class="large-4 medium-4 small-12 columns text-center">
            <img class="show-for-small-only" src="images/icons/vps_step_3.png" alt=""/>
            <h3>הפעל את התוכנית</h3>
            <p>זהו הגיע הזמן להפעיל את השרת הוירטואלי. וודא כי מה שבחרת מתאים לך, והפעל את התוכנית. תוך דקות ספורות תקבל אימייל עם כל הפרטים של השרת החדש שלך.</p>
        </div>
    </div>

</div>
</div>
</div>

<!--  END OF ORDER STEPS  -->

<!--  PRICING BOXES  -->
<div class="pricingboxes">
    <div class="row">
    <?php $wowEffectDelay = 0; $vpsType = 0; ?>
    @foreach ($vpsList as $vps)
        <div data-wow-delay="{{ $wowEffectDelay += 0.5 }}s"  class="small-12 large-3 medium-3 columns wow fadeInUp">
            <div class="title">{{ $vps['id'] }}</div>
            <ul class="pricing-table">
                <li class="description"><strong>{{ $vps['foreign_name'] }}</strong></li>
                <li class="bullet-item">{{ $vps['description'] }}</li>
                <li class="bullet-item">1GB storage</li>
                <li class="bullet-item">{{ $vps['item_os'] }}</li>
                @foreach ($itemTypes[$vpsType] as $itemType)
                    <li class="bullet-item"><span>{{$itemType->name}}</span>  <span><?php echo intval($itemType->quantity)?></span></li>
                @endforeach
                <li class="bullet-item">Free Email Addresses</li>
                <li class="bullet-item">24/7 security monitoring</li>
                <li class="bullet-item">24/7 technical support</li>
                <li class="price"><span>₪{{ (int) $vps['price'] }}</span>כולל מע"מ</li>
                <li class="cta-button"><p><span><a href="{{ url('api/cart/add/' . $vps['id']) }}">הזמן חבילה</a></span></p>
                </li>
            </ul>
        </div>
        <?php $vpsType++; ?>
    @endforeach
    </div>
</div>
<!--  END OF PRCING BOXES  -->
@stop
