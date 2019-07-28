@extends('website.layouts.app')

@section('title', 'SHEV | שאלות נפוצות')

@section('headercolor')
<header class="alt-5">
@stop

@section('msgaboveheader')
<!--  MESSAGES ABOVE HEADER IMAGE -->
<div class="message">
<div class="row">
<div class="small-12 columns">
<div class="message-intro">
<span class="message-line"></span>
<p>שאלות נפוצות</p>
<span class="message-line"></span>
</div>
<h1>כל התשובות שאתה צריך במקום אחד</h1>
</div>
</div>
</div>
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->
@stop

@section('content')
<!--  MAIN PAGE CONTENT  -->
<div id="faq-content">
<div class="faq-subheader">
<div class="row">
<div class="small-12 columns">


<!--  1st CATEGORY FAQ  -->
<div class="faqcategory">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<h1>שאלות כלליות</h1>
</div>
<div class="small-12 large-9 medium-9 columns spacing-top-15">
<div class="question">האם חוות השרתים היא שלכם או שאתם בעצמכם שוכרים שם מקום?</div>
<p>אנחנו שוכרים ארונות תקשורת בחוות השרתים ואליהם אנחנו מקבלים חיבור ישיר לשדירת האינטרנט הארצית והעולמית. כמו-כן,אנחנו גם מפעילים שירותי ענן גלובליים כדוגמת  Amazon AWS ו- Google Cloud שלהם יש את תשתיות חוות השרתים שלהם ואנו שוכרים מהם משאבים לפי הצורך. </p>
<div class="question">האם אתם מציעים שירותי בניית אתרים ואפליקציות לרבות התמיכה בהם?</div>
<p>אנחנו ממוקדים בפעילות אחת: תשתיות לאחסון אתרים. בין אם בחוות השרתים של סלקום ובין אם בתשתיות ענן עולמיות. בניית אתרים ואפליקציות הינה תחום בפני עצמו ואנו עובדים עם שותפים עסקיים שמבצעים את הפעילות הזאת בהצלחה רבה, ונשמח להפנות אותכם אליהם, אך אנו עצמנו לא נהיה מעורבים בפעילות הפיתוח כיוון שהיא מאד ייחודית לכל פרוייקט. </p>
<div class="question">היכן אתם ממוקמים?</div>
<p>משרדינו ממוקמים בתל-אביב, וחוות השרתים העיקרית עמה אנו עובדים (סלקום) נמצאת בפארק אפק ליד ראש העין. </p>
<div class="question">מהי מדיניות האנטי-ספאם ושליחת אימיילים אצלכם?</div>
<p>בקצרה - אנחנו נגד ספאם. באריכה - שליחת אימיילים לחוד ודיוור אלקטרוני להמונים בנפרד. אנחנו מספקים שירותי אימיילים אישיים ומגבילים שליחת אימיילים לקצב של עד 300 אימיילים לדומיין ביום. מעבר לקצב זה, יש צורך בהעברת הלקוח לשרת VPS ייעודי כיוון שבמידה ויש זיהוי (בין אם שגוי ובין אם נכון) שהכתובת אייפי של השרת היא של ספאמר, ההשפעה תהיה על הלקוח ששולח ועליו בלבד.</p>
</div>
</div>
</div>
<!--  1st CATEGORY FAQ  END -->

<!--  2nd CATEGORY FAQ  -->
<div class="faqcategory">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<h1>שרתים , VPSים, וחשבונות אחסון אתרים </h1>
</div>
<div class="small-12 large-9 medium-9 columns spacing-top-15">
<div class="question">כיצד אני מעלה קבצים אל השרת שלי?</div>
<p>כדי להעלות קבצים אל השרת שלך, יש צורך בתוכנת FTP אשר מאפשרת לך לגרור את הקבצים מהמחשב האישי שלך אל השרת. אנחנו ממליצים על תוכנות  FileZilla שהיא די קלה לדעתינו. </p>
<div class="question">הצילו! החשבון שלי הוקפא!</div>
<p>משהו קרה! החשבון שלך אכן הוקפא, וחשוב מאד להבין למה החשבון שלך הוקפא. במידה ומדובר בחבילת אחסון לאתר, יש לוודא כי ניצול המשאבים של החבילה לא הגיע ל-100% מהמשאבים. לדוגמה, אם התעבורה החודשית שלך מוצתה, החשבון שלך אוטומטית יושעה/יוקפא. יש לזכור שבמידה ומדובר בלוח בקרה כדוגמת  DirectAdmin אתה תקבל התראה על ניצול של 80% מהשימוש, וזאת כדי שתוכל לספור את הימים בחודש ולחשב אם החשבון שלך יגיע למיצוי ה-100% של החשבון, בטרם יסתיים החודש.</p>
</div>
</div>
</div>
<!--  2nd CATEGORY FAQ  END -->

<!--  3rd CATEGORY FAQ  >
<div class="faqcategory">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<h1>SERVICES & FEATURES</h1>
</div>
<div class="small-12 large-9 medium-9 columns spacing-top-15">
<div class="question">Is the data center completely owned by you or do you co-locate?</div>
<p>Global leaders overcome injustice solutions sharing economy Global South. Social analysis forward-thinking vulnerable citizens frontline tackling, tackle gun control women and children Gandhi. Facilitate philanthropy our ambitions foundation civil society. Millennium Development Goals transformative, contribution cross-agency coordination global health lifting people up harness. Fundraising campaign expanding community ownership policy advocate economic security compassion. </p>
<div class="question">Do you offer web designing, maintenance and programming services?</div>
<p>Global leaders overcome injustice solutions sharing economy Global South. Social analysis forward-thinking vulnerable citizens frontline tackling, tackle gun control women and children Gandhi. </p>
<div class="question">Where are you located?</div>
<p>Affiliate results challenges medicine positive social change social worker readiness. </p>
<div class="question">What is the policy on "SPAM" and "unsolicited emails"?</div>
<p>Civic engagement transform the world effect convener plumpy'nut. Assistance challenges of our times, committed Kony 2012 institutions nonprofit fairness promising development vaccines. </p>
<div class="question">How do I upload files to my website?</div>
<p>Change lives; vulnerable citizens altruism free-speech raise awareness beneficiaries Jane Addams. Incubation agriculture; volunteer, agency social entrepreneurship; medical rights-based approach. Fluctuation civic engagement complexity citizens of change, momentum civil society impact political. </p>
<div class="question">My domain was suspended for mass mail! Help!</div>
<p>Nutrition reduce carbon emissions urban; transformative research pride peace improving quality. Enabler, 501(c)(3) legitimize; sanitation democratizing the global financial system global network equal opportunity eradicate partner. Inspire breakthroughs; Bill and Melinda Gates outcomes facilitate meaningful work employment. Aga Khan women's rights mobilize, donate overcome injustice design thinking.</p>
</div>
</div>
</div>
<!--  3rd CATEGORY FAQ  END -->

<!--  4th CATEGORY FAQ  >
<div class="faqcategory">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<h1>PRESALES</h1>
</div>
<div class="small-12 large-9 medium-9 columns spacing-top-15">
<div class="question">Is the data center completely owned by you or do you co-locate?</div>
<p>Global leaders overcome injustice solutions sharing economy Global South. Social analysis forward-thinking vulnerable citizens frontline tackling, tackle gun control women and children Gandhi. Facilitate philanthropy our ambitions foundation civil society. Millennium Development Goals transformative, contribution cross-agency coordination global health lifting people up harness. Fundraising campaign expanding community ownership policy advocate economic security compassion. </p>
<div class="question">Do you offer web designing, maintenance and programming services?</div>
<p>Global leaders overcome injustice solutions sharing economy Global South. Social analysis forward-thinking vulnerable citizens frontline tackling, tackle gun control women and children Gandhi. </p>
<div class="question">Where are you located?</div>
<p>Affiliate results challenges medicine positive social change social worker readiness. </p>
<div class="question">What is the policy on "SPAM" and "unsolicited emails"?</div>
<p>Civic engagement transform the world effect convener plumpy'nut. Assistance challenges of our times, committed Kony 2012 institutions nonprofit fairness promising development vaccines. </p>
<div class="question">I get access denied errors when trying to connect to MySQL</div>
<p>Activist dedicated significant; crowdsourcing synthesize, asylum, global leaders collaborative cities metrics. Agenda involvement cross-cultural, focus on impact challenges of our times maintain collaborative consumption. </p>
</div>
</div>
</div>
<!--  4th CATEGORY FAQ  END -->


<!--  5th CATEGORY FAQ  >
<div class="faqcategory">
<div class="row">
<div class="small-12 large-3 medium-3 columns">
<h1>CUSTOMER ACCOUNT</h1>
</div>
<div class="small-12 large-9 medium-9 columns spacing-top-15">
<div class="question">Is the data center completely owned by you or do you co-locate?</div>
<p>Global leaders overcome injustice solutions sharing economy Global South. Social analysis forward-thinking vulnerable citizens frontline tackling, tackle gun control women and children Gandhi. Facilitate philanthropy our ambitions foundation civil society. Millennium Development Goals transformative, contribution cross-agency coordination global health lifting people up harness. Fundraising campaign expanding community ownership policy advocate economic security compassion. </p>
<div class="question">Do you offer web designing, maintenance and programming services?</div>
<p>Global leaders overcome injustice solutions sharing economy Global South. Social analysis forward-thinking vulnerable citizens frontline tackling, tackle gun control women and children Gandhi. </p>
<div class="question">Where are you located?</div>
<p>Affiliate results challenges medicine positive social change social worker readiness. </p>
<div class="question">What is the policy on "SPAM" and "unsolicited emails"?</div>
<p>Civic engagement transform the world effect convener plumpy'nut. Assistance challenges of our times, committed Kony 2012 institutions nonprofit fairness promising development vaccines. </p>
</div>
</div>
</div>
<!--  5th CATEGORY FAQ  END -->

</div>
</div>
</div>
</div>
<!-- END OF MAIN PAGE CONTENT  -->
@stop
