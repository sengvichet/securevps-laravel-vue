<html dir="rtl">
    <body>
        <h1>שלום {{ $accountlist['first_name'] }}</h1>
        לחץ על הלינק הבא כדי ללצפות בחשבונות שלך<br />
        <a href="{{ $accountlist['link'] }}">{{ $accountlist['link'] }}</a>
        <br /><br />
        SHEV Hosting
    </body>
</html>
