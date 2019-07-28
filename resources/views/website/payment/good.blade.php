<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="screen">
    .alert {
        font-size: 16px;
        text-align: right;
        color: #000;
        direction: rtl;
        padding: 30px;
    }
    .red {
        color: #f00;
    }
    .link{
        text-decoration: underline;
        -webkit-text-decoration-color: #9a9dac;
        text-decoration-color: #9a9dac;
        color: #b86662;
        line-height: inherit;
    }
    .link:hover{
        color: #37485C;
        text-decoration: none;
    }
</style>
</head>

<body>
    <div class="alert">
        <b>החיוב בוצע בהצלחה</b><br />
        פרטים:        <b class="red"></b><br />
        <b>תודה לך על התשלום.</b><br />
        <b> כרטיס האשראי שלך יחויב: {{ session("total") }}₪ </b><br>
        <b>בחיובי כרטיס האשראי תראה את החיוב עם התיאור הבא: {{ session('payedFor') }}</b><br>
       <b> לצפיה והורדה של חשבונית מס חתומה דיגיטלית לחץ על:<a class="link" target="_blank" href="/user/invoices"> הסטורית תשלומים</a></b>
    </div>
</body>
</html>
