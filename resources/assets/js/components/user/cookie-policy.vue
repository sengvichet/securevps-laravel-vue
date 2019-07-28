<template lang="html">
    <div>
        <div class="flex-login-container-cookie-policy">
            <div class="message-intro">
                <span class="message-line"></span>
                <p style="color: #b5a8a8;">עוגיות</p>
                <span class="message-line"></span>
            </div>
        </div>
        <div v-if="userCookie">
            <div class="col-md-10 cookie-toggle-position">
                <span class="col-md-9 toogle-text-style">הגדר כן כדי להסתיר את ההתראה על שימוש בקובצי cookie לצמיתות.</span>

                <label class="switch col-md-2" id="switchToggle">
                    <input class="switch-input" type="checkbox" />
                    <span class="switch-label" data-on="Yes" data-off="No"></span>
                    <span class="switch-handle"></span>
                </label>
            </div>
        </div>

        <br>
        <br>

        <div class="flex-login-container-cookie-policy">
            <div class="center-form-box-cookie-policy">
                    <div>
                        <a href="/" class="learn-more">
                            <span style="font-size: 22px">
                            חזור</span>
                        </a>
                        <img src='images/arrow_icon.png'>
                    </div>
                <br>
                <p><strong>מהם קובצי קוקיז?</strong><br>

                    קובצי קוקיז הם מחרוזת אותיות ומספרים, המשמשים לאימות מידע אודות גולש באתר אינטרנט, וכן לשמירה של מידע מסוים לגבי העדפות המשתמש בעת הגלישה. הקוקיז מאוחסנים בדפדפן במחשב, בטלפון החכם או במכשיר אחר המשמש לגישה לאינטרנט ומסייעים לשרתי דפי האינטרנט לאגירת מידע רלוונטי המתייחס למשתמש במהלך ביקורו באתר, ולעתים גם בביקורים עתידיים.                      </p>

                </p><strong>כיצד ומדוע אנו משתמשים בקוקיז?</strong><br>
                אנו משתמשים בקוקיז כדי לשפר את חווית הגלישה.<br>
                הקוקיז מאפשרים לזהות אותך כמשתמש באתר שלנו ובכך לשפר את השירות המוצע לך ואת חווית הגלישה ולבצע בדיקות אבטחת מידע חיוניות אחרות, וכן מאפשרים לך לקבוע העדפות מסוימות בעת הגלישה.
                בנוסף, חלק מהקוקיז מאפשרים להתאים לך תכנים פירסומיים רלוונטים אליך באתר הבנק או באתרים אחרים הקשורים לחברות פרסום איתן אנו עובדים.</p>

                <p><strong>שאלות נפוצות</strong></br>
                    1. האם שימוש בקוקיז משמעותו שאני יכול לקבל דואר זבל?<br>
                    אנחנו אף פעם לא משתמשים בנתונים שנאספו באמצעות קוקיז ליצור איתך קשר באמצעות דואר, דואר אלקטרוני, בטלפון, או לשם משלוח פרסומות. <br>
                    אנו עשויים להשתמש בקוקיז כדי להראות לך תוכן מותאם באתר הבנק או באתרים אחרים.<br><br>

                    2. אם אני משתמש במחשב ציבורי, יהיה מישהו שיוכל לקבל את הפרטים שלי מהקוקיז?<br>

                    לא ניתן לגלות פרטים על משתמש או גולש באמצעות הקוקיז שלנו. הקבצים אינם מכילים פרטים לגבי הלקוח ואינם שומרים את פרטי הגולש. הקוקיז שלנו אינם פוגעים או גורעים מאבטחת השימוש בבנקאות באינטרנט, אלא אוגרים מידע אנונימי בדפדפן במכשיר ממנו מבוצעת הגלישה באתרים מסוימים.<p><br>

                <strong>איך למנוע שימוש בקוקיז?</strong><br>

                ביכולתך למנוע שימוש בקוקיז באופן הבא: עליך להיכנס בחשבונך ל"הגדרות והעדפות" -> "הגדרות ושירותים נוספים" ולבטל את השימוש בקוקיז.<br>
                ניתן  למחוק מהדפדפן קוקיז שנשמרו בעבר  לפי הנתיבים הבאים בכל אחד מהדפדפנים:<br>

                <p><strong>אינטרנט אקספלורר:</strong><br>
                    לשונית כללי > תחת כותרת "היסטוריית גלישה", לחץ על "מחיקה" > סמן ב-V את האפשרות "Cookies and website data" ואז לחץ  על "מחק".</p>

                <p><strong>כרום:</strong><br>
                    תפריט "הגדרות" > תפריט "היסטוריה" > לחץ על כפתור "מחק היסטוריית גלישה" > סמן "cookies and other site and plug-in  data > בחר באפשרות "מחיקה משחר ההיסטוריה" > לחץ על כפתור "מחק היסטוריית גלישה".</p>

                <p><strong>פיירפוקס:</strong><br>
                    לשונית היסטוריה > ניקוי היסטוריה אחרונה > סמן בV- את האפשרות "עוגיות" > לחץ על "מחק עכשיו".</p>

                <p><strong>חשוב:</strong><br>
                    השבתה כללית של קוקיז, עלולה לפגוע במתן שירותים ובנתונים אחרים אודות העדפותיך והרגלי הגלישה שלך. מחיקת כלל <br>
                    הקוקיז עלולה לגרום למחיקת נתונים ושירותים אחרים מאלה של הבנק בהם הנך עושה שימוש בעת הגלישה.</p>
            </div>
        </div>
    </div>
</template>

<script>
    import { userStore } from '../../stores'

    export default {
        components: {
        },

        data ()
        {
            return {
                loading: true,
                userCookie: 0
            }
        },

    created () {
    },
    mounted () {
      this.getSessionResult();
    },

    methods: {
        getSessionResult () {
            userStore.getSessionResult().then((data) => {
                this.userCookie = data;
            }).catch(error => {
                this.userCookie = 0;
            })
        }

    }
    }
</script>
