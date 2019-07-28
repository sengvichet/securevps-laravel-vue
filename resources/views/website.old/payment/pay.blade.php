<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="screen">
    .loading {
        font-size: 20px;
        text-align: center;
        color: #aaa;
        width: 100%;
        direction: rtl;
    }
</style>
</head>

<body>
<div class="loading">
    עוד רגע אחד...
</div>

 <div style="visibility:hidden" >
 <form id="form4" name="form4" action="https://gateway.pelecard.biz/Iframe" method="post">
<?php
	$password = str_replace("+", "`9`", $sdata['password']);
	$password = str_replace("&", "`8`", $password);
	$password = str_replace("%", "`7`", $password);

    $debugPayment = true;
    if ($debugPayment) {
         $total = rand(1, 5);
//        $total = rand(50, 59);
    } else {
        $total = $sdata['total']*100;
    }

    $data = [
        'userName' => $sdata['userName'],
        'password' => $password,
        'termNo' => $sdata['termNo'],
        'pageName' => 'ajaxPage',
        'goodUrl' => url('/payment/good'),
        'errorUrl' => url('payment/error'),
        'ValidateLink' => '',
        'ErrorLink' => '',
        'total' => $total,
        'currency' => '1',
        'maxPayments' => '1',
        'minPaymentsNo' => '1',
        'creditTypeFrom' => '7',
        'logo' =>  "https://secure.shev.com/png-03.png",
        'smallLogo' => "https://gateway.pelecard.biz/Content/images/Pelecard.png",
        'hidePciDssLogo' => '',
        'hidePelecardLogo' => '',
        'Theme' => '2',
        'Background' => '',
        'backgroundImage' => '',
        'topMargin' => '',
        'supportedCardTypes' => "True,True,True,True,True",
        'parmx' => $sdata['DomainName'] . '-' . $sdata['OrderID'],
        'hideParmx' => '',
        'text1' => "הזמנה מספר: &lt;b&gt;" . $sdata['OrderID'] . "&lt;/b&gt;",
        'text2' => "שם דומיין בהזמנה: &lt;b&gt;" . $sdata['DomainName'] . "&lt;/b&gt;",
        //'text3' => "שם הלקוח/נציג: &lt;b&gt;" . $sdata['ClientName'] . "&lt;/b&gt;",
        'text4' => "שם הגוף המחייב: &lt;b&gt;סולל יבוא ורשתות (1997) בעמ&lt;/b&gt;",
        'text5' => "לבירורים: &lt;b&gt;03-6421228 &lt;/b&gt; או אימייל:&lt;b&gt; hosting@shev.com&lt;/b&gt;",
        'cancelUrl' => '',
        'mustConfirm' => '',
        'confirmationText' => '',
        'supportPhone' => "03-6421228",
        'errorText' => '',
        'id' => 'Must',
        'cvv2' => 'Must',
        'authNum' => '',
        'shopNo' => '001',
        'frmAction' => 'CreateToken',
        'TokenForTerminal' => '',
        'J5' => '',
        'keepSSL' => '' ## NO TRAILING COMMA
    ];


	list ($code, $result) = do_post_request($data);

	## Submit the data into pelecard servers
    function do_post_request($data, $optional_headers = null)
    {
        $params = [
           'http' => [
               'method' => 'POST',
               'content' => http_build_query($data)
            ]
        ];

        $url = 'https://gateway.pelecard.biz/Iframe';
        // $url = 'https://gateway.pelecard.biz';

        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }

        $ctx = stream_context_create($params);

        $fp = @fopen($url, 'rb', false, $ctx);
        fpassthru($fp);
        if (!$fp) {
            throw new Exception("Problem with $url, $php_errormsg");
        }

        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url, $php_errormsg");
        }

        return array(substr(trim(strip_tags($response)), 0, 3), trim(strip_tags($response)));
    }

?>


<input type="hidden" name="noCheck" value="true" id="noCheck" />
</form>
<script type='text/javascript'>
function submitForm() { document.form4.submit();}
submitForm();
</script>
 </div>
</body>
</html>
