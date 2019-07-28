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
</style>
</head>

<body>
    <div class="alert">
        <b>אנו מצטערים אך פעולת הסליקה נכשלה</b><br />
        קוד שגיאה: <b class="red">{{ $errorCode }}</b><br />
        הסיבה: <b class="red">{{ $errorMsg }}</b><br />
    </div>
</body>
</html>
