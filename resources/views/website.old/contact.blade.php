@extends('website.layouts.app')

@section('title', 'SHEV | יצירת קשר')

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
<p>צרו קשר</p>
<span class="message-line"></span>
</div>
<h1>תהיו בקשר :-)</h1>
</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

@section('content')
<!--  CONTACT CONTENT  -->
<div class="contact-section">
<div class="row">
<div class="small-12 large-4 medium-4 columns">
<p>
נשמח לעמוד לרשותכם בכל שאלה או בקשה:
</p>

<div class="contact-details">
<h4>SHEV.COM</h4>
אחסון שרתים מאובטחים
<ul>
<li><span>סולל יבוא ורשתות (1997) בע"מ</span>
רח' הרכש 34
<br />
תל-אביב, מיקוד 69699
﻿ </li>
<li>טלפון 03-642-1228</li>
<li>טלפון חירום 052-3869891</li>
<li>פקס 03-744-0989</li>
<li>אימייל <a href="mailto:hosting@shev.com" title="">hosting@shev.com</a></li>
</ul>
</div>
</div>
<div class="small-12 large-8 medium-8 columns">
<div id="gmap">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3379.0312127871507!2d34.81132822084781!3d32.12245932447065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151d490d3239bfc3%3A0x2a3c77ab84a7b4ab!2z16HXldec15wg15nXkdeV15Ag15XXqNep16rXldeqICgxOTk3KSDXkdeiItee!5e0!3m2!1siw!2sil!4v1481376866484" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

<div id="sendstatus"></div>
<div id="contactform">
<form method="post" action="sendmail.php">

            <p><label for="name">שם:*</label> <input type="text" name="name" id="name" tabindex="1" /></p>
            <p><label for="email">אימייל:*</label> <input type="text" name="email" id="email" tabindex="2" /></p>
            <p><label for="comments">הודעה:*</label> <textarea name="comments" id="comments" cols="12" rows="6" tabindex="3"></textarea></p>
            <p><input type="submit" class="button" name="submit" id="submit" value="שלח הודעה" tabindex="4" /></p>

</form>
</div>

</div>
</div>
</div>
<!--  END OF CONTACT CONTENT  -->
@stop
