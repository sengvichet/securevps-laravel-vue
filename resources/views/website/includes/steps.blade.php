<!--  ORDER STEPS  -->
<div class="vps-order-steps">
<div class="row">
<div class="small-12 columns">
{{-- <h2>הרשמה לאתר בפשטות ובמהירות</h2>
<p>כאן תוכל לפתוח חשבון ולנהל את חבילת האחסון שלך</p> --}}

<div class="row">
    <div class="large-12 columns hide-for-small-only">
        <div class="order-step">
            <div class="row">
                <div data-wow-delay="0.2s" class="order-circle large-3 medium-3 columns wow fadeInUp">
                    <div class="line left-side"></div>
                    <span class="left-side {{ $bulletstep['activestepa'] }}">1</span>
                </div>
                <div data-wow-delay="0.4s" class="order-circle large-3 medium-3 columns wow fadeInUp reg-circle-inherit" style="padding-right: inherit">
                    <div class="line"></div>
                    <span class="{{ $bulletstep['activestepb'] }}">2</span>
                </div>
                <div data-wow-delay="0.6s" class="order-circle large-3 medium-3 columns wow fadeInUp reg-circle-inherit" style="padding-right: inherit">
                    <div class="line"></div>
                    <span class="{{ $bulletstep['activestepc'] }}">3</span>
                </div>
                <div data-wow-delay="0.8s" class="order-circle large-3 medium-3 columns wow fadeInUp">
                    <div class="line right-side"></div>
                    <span class="right-side {{ $bulletstep['activestepd'] }}">4</span>
                </div>
            </div>
        </div>
    </div>
    <div class="large-3 medium-3 small-12 columns text-center">
        <img class="show-for-small-only" src="{{ url('images/icons/vps_step_1.png') }}" alt="" />
        <h3 class="{{ $bulletstep['activestepa'] }}">פרטי משתמש</h3>
        <p>הזן פרטים בסיסיים, לאחר השליחה תקבל אימייל לאימות כתובת הדואר שלך, לחץ על הקישור המצורף במייל</p>
    </div>
    <div class="large-3 medium-3 small-12 columns text-center">
        <img class="show-for-small-only" src="{{ url('images/icons/vps_step_2.png') }}" alt=""/>
        <h3 class="{{ $bulletstep['activestepb'] }}">מספר טלפון נייד</h3>
        <p>הזן מספר טלפון נייד, לאחר שליחת הטופס תקבל SMS עם קוד לאישור</p>
    </div>
    <div class="large-3 medium-3 small-12 columns text-center">
        <img class="show-for-small-only" src="{{ url('images/icons/vps_step_3.png') }}" alt=""/>
        <h3 class="{{ $bulletstep['activestepc'] }}">הזן קוד SMS</h3>
        <p>הזן את קוד הSMS שקיבלת על מנת לאשר את מספר הטלפון שלך</p>
    </div>
    <div class="large-3 medium-3 small-12 columns text-center">
        <img class="show-for-small-only" src="{{ url('images/icons/vps_step_3.png') }}" alt=""/>
        <h3 class="{{ $bulletstep['activestepd'] }}">בחירת סיסמה</h3>
        <p>שלב אחרון בחירת הסיסמה שלך למערכת</p>
    </div>
</div>

</div>
</div>
</div>
