@extends('website.layouts.app')

@section('title', 'SHEV | תעודות SSL מאובטחות וכתובות אייפי')

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
                            <p>תעודות SSL וכתובות אייפי</p>
                            <span class="message-line"></span>
                        </div>
                        <h1>תעודות SSL לאתרים וכתובות אייפי</h1>
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
                        <h2>כמעט כל אתר היום צריך תעודת SSL - סביר להניח שגם האתר שלך!</h2>
                        <p>בעקבות שינויים במערכת של גוגל, כעת כדי לקבל אינדוקס בגוגל, אתרים שיש בהם אפשרות התחברות ו/או סליקה, מחוייבים להיות עם תעודת SSL תקינה כחלק מהצגת האתר. לשם כך, אנחנו מאפשרים ללקוחותינו להפעיל את המנגנון של התקנת תעודות ה-SSL בצורה עצמאית (או בעזרתינו) כאשר ניתן להזמין תעודת SSL בחינם או בתשלום (תלוי לפי הצורך)</p>
                    </div>
                </div>
            </div>

            <!--  PRICING BOXES  -->
            <div class="pricingboxes">
                <div class="row">
                    <div data-wow-delay="0.2s"  class="small-12 large-4 medium-4 columns wow fadeInLeft">
                        <div class="title">Let’s Encrypt<br> התעודה החינמית הזמינה לשרתי לינוקס</div>
                        <ul class="pricing-table">
                            <li class="description">תעודה חינמית מבית  Let’s Encrypt </li>
                            <li class="bullet-item">ללא צורך בכתובת אייפי פרטית</li>
                            <li class="bullet-item">מוכרת ב-99.9% מהדפדפנים</li>
                            <li class="bullet-item">התקנה עצמאית (או בעזרתינו)</li>
                            <li class="bullet-item">מאפשרת עד 20 סאב דומיינים</li>
                            <li class="price"><span>חינם</span>מתחדש אוטומטית כל 3 חודשים</li>
                            <li class="cta-button"><p><span><a href="">זמין אוטומטית</a></span></p></li>
                        </ul>
                    </div>

                    <div data-wow-delay="0.4s"  class="small-12 large-4 medium-4 columns wow fadeInUp">
                        <div class="title">Comodo PositiveSSL<br>התעודה הזולה ביותר לכל סוגי השרתים</div>
                        <ul class="pricing-table">
                            <li class="description">תעודה מבית  Comodo</li>
                            <li class="bullet-item">ללא צורך בכתובת אייפי פרטית</li>
                            <li class="bullet-item">מוכרת ב-100% מהדפדפנים</li>
                            <li class="bullet-item">דורשת הליך אימות ידני</li>
                            <li class="bullet-item">נעולה לדומיין ול-WWW של הדומיין</li>
                            <li class="price"><span>160 ש"ח</span>לשנה</li>
                            <li class="cta-button"><p><span><a href="">הזמן כעת</a></span></p></li>
                        </ul>
                    </div>

                    <div data-wow-delay="0.6s"  class="small-12 large-4 medium-4 columns wow fadeInRight">
                        <div class="title">Comodo PositiveSSL Multi-Domain<br>התעודה המאפשרת מספר דומיינים בבת אחת</div>
                        <ul class="pricing-table">
                            <li class="description">תעודה מבית Comodo</li>
                            <li class="bullet-item">ללא צורך בכתובת אייפי פרטית</li>
                            <li class="bullet-item">מוכרת ב-100% מהדפדפנים</li>
                            <li class="bullet-item">דורשת הליך אימות ידני</li>
                            <li class="bullet-item">מאפשר הוספה של סאב דומיינים בתשלום לפי דרישה</li>
                            <li class="price"><span>220 ש"ח</span>לשנה</li>
                            <li class="cta-button"><p><span><a href="">הזמן כעת</a></span></p></li>
                        </ul>
                    </div>

                </div>
            </div>
            <!--  END OF PRCING BOXES  -->

            <!--  END OF BUDGET SERVERS  -->

@stop
