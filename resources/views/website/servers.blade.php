@extends('website.layouts.app')

@section('title', 'SHEV | שרתים ייעודיים ושירות co-location')

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
<p>שרתים ייעודיים ושירותי  co-location</p>
<span class="message-line"></span>
</div>
<h1>שדירת האינטרנט עם הציוד שלכם!</h1>
</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

@section('content')
<!-- BUDGET SERVERS   -->
<div class="features servers">
<div class="row">
<div class="small-12 columns">
<h2>שרת פיזי שכל כולו רק שלכם</h2>
<p>רוצים שרת שלם רק לעצמכם או אולי יש לכם שרת ואתם רוצים לשים אותו בחוות השרתים שלנו - בין אם בארון תקשורת עצמאי או חלקי - אנחנו נותנים את שירות מקצה לקצה</p>
</div>
</div>
</div>


<!--  PRICING BOXES  -->
<div class="pricingboxes">
<div class="row">
<div data-wow-delay="0.2s"  class="small-12 large-4 medium-4 columns wow fadeInLeft">
<div class="title">אירוח שרת וציוד ייעודי בחוות השרתים</div>
<ul class="pricing-table">
<li class="description">חיובים לפי יחידות 1U</li>
<li class="bullet-item">הזנות חשמל כפולות</li>
<li class="bullet-item">חיבורי Giga לסוויטשים</li>
<li class="bullet-item">אפשרות לחיבור ציוד  KVMoverIP</li>
<li class="bullet-item">ניטור ואבטחה של הארון</li>
<li class="bullet-item">שירותי איפוס אצבע (ריבוט על פי דרישה*)</li>
<li class="price"><span>$109</span>MONTHLY</li>
<li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
</ul>
</div>

<div data-wow-delay="0.4s"  class="small-12 large-4 medium-4 columns wow fadeInUp">
<div class="title">השכרת ארון תקשורת שלם בחווה</div>
<ul class="pricing-table">
<li class="description">עד 38U לשימוש שרתים וציוד תקשורת</li>
<li class="bullet-item">הגבלת גישה פיזית לארון ולציוד בו (לפי החלטת הלקוח)</li>
<li class="bullet-item">רוחב פס מנוטר מהחווה</li>
<li class="bullet-item">טווחי כתובות אייפי לפי דרישה</li>
<li class="bullet-item">ניטור ואבטחה של הארון</li>
<li class="bullet-item">שירותי איפוס אצבע (ריבוט על פי דרישה*)</li>
<li class="price"><span>$139</span>MONTHLY</li>
<li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
</ul>
</div>

<div data-wow-delay="0.6s"  class="small-12 large-4 medium-4 columns wow fadeInRight">
<div class="title">תמסורות -ו-APN</div>
<ul class="pricing-table">
<li class="description"><strong>Root</strong> Access</li>
<li class="bullet-item">1GB storage</li>
<li class="bullet-item">3GB bandwidth</li>
<li class="bullet-item">Free Email Addresses</li>
<li class="bullet-item">24/7 security monitoring</li>
<li class="bullet-item">24/7 technical support</li>
<li class="price"><span>$169</span>MONTHLY</li>
<li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
</ul>
</div>


</div>
</div>
<!--  END OF PRCING BOXES  -->

<!--  END OF BUDGET SERVERS  -->





<!-- DEDICATED SERVER FEATURES   -->
<div class="dedicated-servers-features">
<div class="row">
<div class="small-12 columns">
<h2>שרתים יעודים שפשוט עובדים</h2>
<p>צריכים שרת מבוסס windows? לינוקס? שרתי דואר אלקטרוני בענן? שרת גיבויים בענן? צוות המומחים שלנו ישמח להעניק לכם שירות מקצועי שייקח את הארגון שלכם צעד אחד קדימה</p>


<ul class="small-block-grid-1 large-block-grid-2 medium-block-grid-2">

<li  data-wow-delay="0.3s" class="wow fadeInLeft">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<img src="images/icons/server-features-1.png" alt=""/>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>ביצועים גבוהים</h3>
<p>השרתים שלנו מבוססי חומרה איכותית בעלת ביצועים גבוהים המתאימים במדויק לארגון שלכם</p>
</div>
</div>
</li>

<li  data-wow-delay="0.3s" class="wow fadeInRight">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<img src="images/icons/server-features-6.png" alt=""/>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>מכל מקום בעולם</h3>
<p>באמצעות חיבור ל-CDN השרת שלכם יגיב במהירות גבוהה מכל מקום בעולם</p>
</div>
</div>
</li>

<li  data-wow-delay="0.6s" class="wow fadeInLeft">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<img src="images/icons/server-features-5.png" alt=""/>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>אבטחת מידע ותעודות SSL</h3>
<p>השרתים היעודיים שלנו מחוברים ל-Firewall חומרתי חזק ואיכותי ובנוסף ניתן בקלות להגדיר תעודות SSL שירותי הצפנה, Firewall תוכנתי, אינטי וירוס וחבילות נוספות בהתאם לצרכי הארגון</p>
</div>
</div>
</li>

<li  data-wow-delay="0.6s" class="wow fadeInRight">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<img src="images/icons/server-features-4.png" alt=""/>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>הזמן שלכם יקר לנו</h3>
<p>השרת היעודי שלכם מוכן במהירות שיא ובאיכות הגבוהה ביותר. צוות המומחים שלנו ישמור על זמן תגובה מהיר במיוחד על מנת לתת לכם את השירות הטוב ביותר</p>
</div>
</div>
</li>

<li  data-wow-delay="0.9s" class="wow fadeInLeft">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<img src="images/icons/server-features-2.png" alt=""/>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>אנחנו אוהבים לתת שירות מנצח</h3>
<p>אנחנו כל כך אוהבים את העבודה שלנו ואוהבים לתת את השירות המקצועי והמקיף ביותר. זו הסיבה שיותר ויותר לקוחות בוחרים בשירות הייחודי שלנו ברמה הגבוהה ביותר כמו שרק אנחנו יכולים לתת</p>
</div>
</div>
</li>

<li  data-wow-delay="0.9s" class="wow fadeInRight">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<img src="images/icons/server-features-3.png" alt=""/>
</div>
<div class="small-12 large-9 medium-9 columns">
<h3>ניתן לשינוי בקלות</h3>
<p>רוצים להוסיף שירותי גיבוי אוטומטיים? מקום אחסון נוסף? רוצים להתקין על השרת לוח ניהול מסוג DirectAdmin, Cpanel או Plask? תוכלו להתאים באופן מלא את השרת שלכם לצרכי הארגון צוות המומחים שלנו ישמח לתת לכם שירות מקיף מקצה לקצה</p>
</div>
</div>
</li>

</ul>

</div>

</div>
</div>
<!-- DEDICATED SERVER FEATURES   -->
@stop
