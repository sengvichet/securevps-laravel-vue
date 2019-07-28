<?php

ini_set('display_errors', true);

$sapResponse = '';
$xmlBody = '';

if(!empty($_POST["xmlBody"]))
{
    $xmlBody = $_POST["xmlBody"];

    // allocate curl
    $curl = curl_init('http://212.150.41.90/testforsite/SapBusinessOne_WebService_BP.asmx?op=SetBPCookie');

    // initialize curl
    curl_setopt($curl, CURLOPT_HEADER, 				0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 		1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 		1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, 			array( "Content-Type: application/soap+xml; charset=utf-8" ) );
    curl_setopt($curl, CURLOPT_POST, 				1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, 			stripslashes($xmlBody));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 		0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 		0);

    // get data
    $sapResponse = curl_exec($curl);

    // close curl
    curl_close($curl);
}

?>

<html>
<head>
    <title>SAP Test Page</title>
</head>

<body>
<?php
if ($xmlBody === '') {
    $xmlBody = '<?xml version="1.0" encoding="UTF-8"?><env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope"><env:Body><SetBPCookie><websiteUer>EEO061204</websiteUer><ip>127.0.0.1</ip><date>2017-12-11 16:45:02.539892</date><browser>Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36</browser><status>1</status></SetBPCookie></env:Body></env:Envelope>';
}
?>
<form method="post" action="">

    <h3>SAP Web Service Request</h3>

    <textarea name="xmlBody" rows="20" cols="100"><?php echo stripslashes($xmlBody); ?></textarea><br><br>

    <br><br>
    <input type="submit" value="Send Request" />

    <h3>SAP Web Service Response</h3>

    <div style="width:1200px;word-wrap: break-word;"><?php echo htmlspecialchars($sapResponse); ?></div>

</form>
</body>

</html>

