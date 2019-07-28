@extends('website.layouts.app')

@section('title', 'SHEV | שרתים וירטואליים, אחסון אתרים')

@section('headercolor')
    <header>
    @stop

    @section('msgaboveheader')
        <!--  MESSAGES ABOVE HEADER IMAGE -->
            <a href="/feedback">Click Me</a>
            <div class="message">
                <div class="row">
                    <div class="small-12 columns">
                        <div class="message-intro">
                            <span class="message-line"></span>
                            <p>אחסון שרתים מאובטחים</p>
                            <span class="message-line"></span>
                        </div>
                        <h1><span id="js-rotating">מכונות וירטואליות עוצמתיות, ענן לאתרים ואפליקציות, הפעלת חשבונות מיידית, ביצועי מעבד והארד דיסק מעולים, חווית ענן אמיתית</span></h1>
                        <a href="#pricingboxes" class="small radius button">צפיה בחבילות אחסון</a>
                    </div>
                </div>
            </div>
            <!--  END OF MESSAGES ABOVE HEADER IMAGE -->
    @stop

    @section('content')
        <!--  FEATURES -->
            <section class="features">
                <div class="row">
                    <div class="small-12 columns">
                        <h2>היתרונות שקשה לנצח</h2>
                        <p>אספנו עבורכם את המשאבים הכי חזקים והכי רלוונטים למפתחי אתרים, אתרי מסחר, אפליקציות ואתרי תדמית. רשימת המשאבים המופעלים ועומדים לרשותכם פה היא חלקית בלבד.</p>

                        <ul class="small-block-grid-1 large-block-grid-3 medium-block-grid-3">

                            <li  data-wow-delay="0.2s" class="wow fadeInLeft">
                                <i class="fa fa-database"></i>
                                <h3>מסדי נתונים בענן</h3>
                                <p>אנו מפעילים מסדי נתונים MySQL, MSSQL בכל הגרסאות המבוקשות</p>
                            </li>

                            <li data-wow-delay="0.4s" class="wow fadeInLeft">
                                <i class="fa fa-git-square"></i>
                                <h3>גישות להתקנות חיבורים ל git</h3>
                                <p>הכנת גישה ל-git כדוגמת bitbucket ודומיו בשרתי VPS ייעודיים</p>
                            </li>

                            <li data-wow-delay="0.6s" class="wow fadeInLeft">
                                <i class="fa fa-code"></i>
                                <h3>כלי פיתוח צד שרת למתפתחים</h3>
                                <p>מפתחים צריכים גישות SSH, גישות ל  Composer, גישות ל- vi, וכלים נוספים</p>
                            </li>

                            <li data-wow-delay="0.2s" class="wow fadeInRight">
                                <i class="fa fa-bolt"></i>
                                <h3>תקשורת Gigabit ו-10GB לחוות השרתים</h3>
                                <p>כל שרתי האחסון מחוברים לסוויטשים מסוג  Enterprise Class של  Cisco בחיבורי  Gigabit ו- 10Gigabit</p>
                            </li>

                            <li data-wow-delay="0.4s" class="wow fadeInRight">
                                <i class="fa fa-hdd-o"></i>
                                <h3>שרתים עם SSD לביצועים מקסימליים</h3>
                                הארד דיסקים של SAS לחיבורי  Enterprise, לביצועים מקסימליים עם   15K RPM או עם  SSD לביצועי על.</p>
                            </li>

                            <li data-wow-delay="0.6s" class="wow fadeInRight">
                                <i class="fa fa-rocket"></i>
                                <h3>הקצאת משאבים לפי דרישה</h3>
                                <p>אפשרות הוספת משאבים לפי הצורך למניעת בזבוז משאבים ועלויות מיותרות</p>
                            </li>

                        </ul>
                    </div>
                </div>
            </section>
            <!--  END OF FEATURES -->

            <!--  CALL TO ACTION  -->
            <section class="calltoaction">
                <div class="row">
                    <div class="small-12 columns">
                        <div data-wow-delay="0.3s" class="longshadow wow fadeInDown">לקוח חדש!</div>
                        <div data-wow-delay="0.5s" class="calltoactioninfo wow fadeInUp">
                            <h2><span id="discount">0</span><span>%</span> הנחה בהזמנה ראשונה חדשה</h2>
                            <h3>השתמש בקופון ההנחה <strong>"CLOUDMENEW"</strong></h3>
                            <a href="#" class="small radius button">הזמן כעת!</a>
                        </div>
                    </div>
                </div>
            </section>
            <!--  END OF CALL TO ACTION -->

            <!--  PRICING BOXES  -->
            <div class="pricingboxes">
                <a id="pricingboxes"></a>
                <div class="row">
                    <div class="small-12 columns">
                        <h2>מצא תוכנית מותאמת במיוחד בשבילך</h2>
                        <p>בין אם מדובר באחסון אתר תדמיתי קטן, שרת VPS עם פעילות פיתוח, שרת ייעודי לחלוטין, פתרונות ענן גלובלי (כדוגמת אמזון AWS, או גוגל Cloud) או ארון תקשורת ייעודי, יש ברשותינו תמיד את המשאבים המבוקשים.</p>
                    </div>
                </div>

                <div class="spacing-30"></div>

                <div class="row">
                    <div data-wow-delay="0.4s"  class="small-12 large-4 medium-4 columns wow zoomIn">
                        <div class="title">אחסון שיתופי</div>
                        <ul class="pricing-table">

                            <li class="description">100% <strong>Linux & Windows</strong> ידידותי</li>
                            <li class="bullet-item">500MB מקום אחסון</li>
                            <li class="bullet-item">16GB תעבורה חודשית</li>
                            <li class="bullet-item">כתובות אימייל משוייכות לדומיין</li>
                            <li class="bullet-item">ניטור ובקרה 24/7</li>
                            <li class="bullet-item">24/7 תמיכה טכנית חירום</li>
                            <li class="bullet-item">
                                <div>החל מ:</div>
                                <div class="price"><span>70 ₪</span>לחודש</div>
                            </li>
                            <li class="cta-button"><p><span><a href="http://secure20.shev.com/shared">הזמן עכשיו</a></span></p></li>
                        </ul>
                    </div>

                    <div data-wow-delay="0.4s"  class="small-12 large-4 medium-4 columns wow zoomIn">
                        <div class="title">שרת בענן</div>
                        <ul class="pricing-table">
                            <li class="description">הקמה תוך <strong>דקות </strong>ספורות</li>
                            <li class="bullet-item">30GB מקום אחסון</li>
                            <li class="bullet-item">10Mbit רוחב פס מובטח</li>
                            <li class="bullet-item">גיבויי  snapshots ל-10 ימים</li>
                            <li class="bullet-item">24/7 ניטור ובקרה</li>
                            <li class="bullet-item">24/7 תמיכת חירום</li>
                            <li class="bullet-item">
                                <div>החל מ:</div>
                            	<div class="price"><span>300  ₪</span>לחודש</div>
			   </li>
                            <li class="cta-button"><p><span><a href="">הזמן כעת</a></span></p></li>
                        </ul>
                    </div>

                    <div data-wow-delay="0.6s"  class="small-12 large-4 medium-4 columns wow zoomIn">
                        <div class="title">Amazon AWS / Google Cloud</div>
                        <ul class="pricing-table">
                            <li class="description">סביבה עולמית - ענן ציבורי</li>
                            <li class="bullet-item">נפח אחסון לפי הצורך - חיוב פרטני</li>
                            <li class="bullet-item">משאבי מעבד, זיכרון ותעבורה ב Ad-hoc</li>
                            <li class="bullet-item">Big Data לפי הצורך</li>
                            <li class="bullet-item">לוח בקרה וניהול של הספק (אמזון או גוגל)</li>
                            <li class="bullet-item">24/7 technical support</li>
                            <li class="bullet-item">
                                <div>החל מ:</div>
                            	<div class="price"><span>$199</span>לחודש</div>
                            <li class="cta-button"><p><span><a href="">SIGN UP NOW</a></span></p></li>
                        </ul>
                    </div>

                </div>
            </div>
            <!--  END OF PRCING BOXES  -->

            <!--  TESTIMONIALS  -->
            <section class="testimonials">
                <div class="row">
                    <div class="small-12 columns">
                        <div class="circle"><i class="fa fa-heart"></i></div>
                        <h2>מפתחים וסביבות פיתוח <span id="lovedby">0</span> מרוצים</h2>
                        <hr class="small"/>

                        <div id="testimonials-carousel" class="owl-carousel">

                            <div class="item">
                                <div class="whoclient"><span>Petr Wright, Developer at <a href="">Aina Corp.</a></span></div>
                                <div class="testimonial-content">
                                    <div class="testimonialimg"><img src="images/hn-200x200.jpg" alt="" /></div>
                                    <p>Semiotics ennui shabby chic irony Tumblr. Letterpress Cosby sweater put a bird on it ethnic fap Portland. Ethnic Pitchfork brunch, kogi crucifix cornhole fanny pack. Squid PBR artisan, Austin gastropub vegan lo-fi sustainable ethnic. Before they sold out 8-bit aesthetic ethnic mixtape.</p>
                                </div>
                            </div>

                            <div class="item">
                                <div class="whoclient"><span>Neil Wynter, Developer at <a href="">Reise S.A.</a></span></div>
                                <div class="testimonial-content">
                                    <div class="testimonialimg"><img src="images/jo-200x200.jpg" alt="" /></div>
                                    <p>Voluptate kogi VHS, occupy hella banh mi Thundercats Godard jean shorts plaid in cred food truck. Plaid fingerstache craft beer, disrupt labore Tonx exercitation single-origin coffee assumenda raw denim delectus kogi. Thundercats proident photo booth Truffaut, banjo duis 8-bit church-key sunt mollit selvage elit Cosby.</p>
                                </div>
                            </div>

                            <div class="item">
                                <div class="whoclient"><span>Darron Williams, Developer at <a href="">Joseph Ltd.</a></span></div>
                                <div class="testimonial-content">
                                    <div class="testimonialimg"><img src="images/sm-200x200.jpg" alt="" /></div>
                                    <p>Deep v bespoke ethical, fanny pack ea Odd Future sapiente chia et synth id slow-carb sriracha nesciunt tote bag. Meggings ex pug, enim Odd Future ea salvia deep v sartorial mlkshk literally yr sapiente. Shoreditch deserunt master cleanse, try-hard McSweeney's whatever art party put a bird on it pork.</p>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </section>
            <!--  END OF TESTIMONIALS -->

            <!--  MONITORING  -->
            <section class="monitoring">
                <div class="row">
                    <div class="small-12 columns">
                        <h2>ניטור אקטיבי 24/7 לביצועי שרתים</h2>
                        <p class="text-center">מעקב אחר זמינות שרתים, אתרים וניטור עומסים</p>
                        <div data-wow-delay="0.3s" class="text-center wow fadeInUp"><img src="images/monitoring.png" alt=""/></div>
                    </div>
                </div>
            </section>
            <!--  END OF MONITORING  -->

@stop
