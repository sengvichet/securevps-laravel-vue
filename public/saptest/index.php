<?php

ini_set('display_errors', true);

$sapRequest  = '';
$sapResponse = '';

if(!empty($_POST))
{
	$sapRequest = $_POST["sapRequest"];
	$baseurl = $_POST["baseurl"];
	$service = $_POST["service"];

	// allocate curl
	$curl = curl_init($baseurl . $service . '.asmx');

	// initialize curl
    curl_setopt($curl, CURLOPT_HEADER, 				0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 		1);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 		1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, 			array( "Content-Type: application/soap+xml; charset=utf-8" ) );
	curl_setopt($curl, CURLOPT_POST, 				1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, 			stripslashes($sapRequest));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 		0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 		0);

	// get data
	$sapResponse = curl_exec($curl);

	// close curl
	curl_close($curl);
} else {
    if (! empty($_GET)){
        $service = isset($_GET['service']) ? $_GET['service'] : '';
        $sapRequestUrl = isset($_GET['sapRequestUrl']) ? $_GET['sapRequestUrl'] : '';
        $sapRequest = file_get_contents('xml/' . $sapRequestUrl . '.txt');
    }
}

?>

<html>
<head>
<title>SAP Test Page</title>
</head>

<body>

<?php
if (! isset($baseurl)) {
    $baseurl = 'http://212.150.41.90/TestForSite/';
}
?>
http://secure19.shev.com/saptest/index.php?service=SapBusinessOne_WebService_InvoiceAndReceipt&sapRequestUrl=GetAllDomainInvoices
<br><br>

	<form method="post" action="http://secure20.shev.com/saptest/index.php">

        <h3>SAP Web Service Request</h3>

        base url: <input type="text" name="baseurl" size="80" value=<?php echo $baseurl ?>><br><br>
        service:
        <select name="service">
            <option><?= isset($service) ? $service : '' ?></option>
            <option>GetBPCookie</option>
            <option>SetBPCookie</option>
            <option>SapBusinessOne_WebService_Admin</option>
            <option>SapBusinessOne_WebService_BP</option>
            <option>SapBusinessOne_WebService_Inventory</option>
            <option>SapBusinessOne_WebService_InvoiceAndReceipt</option>
            <option>SapBusinessOne_WebService_Login</option>
            <option>SapBusinessOne_WebService_MainPageView</option>
            <option>SapBusinessOne_WebService_Registration</option>
            <option>SapBusinessOne_WebService_SalesOrder</option>
            <option>SapBusinessOne_WebService_Registration</option>
            <option>SapBusinessOne_WebService_GetAllItems</option>
            <option>SapBusinessOne_WebService_MainPageView</option>
        </select>
        <br><hr><br>
		<textarea name="sapRequest" rows="20" cols="100"><?php echo $sapRequest; ?></textarea><br><br>

        <br><br>
        <input type="submit" value="Send Request" />

		<h3>SAP Web Service Response</h3>

		<div style="width:1200px;word-wrap: break-word;"><?php echo htmlspecialchars($sapResponse); ?></div>
	</form>

</body>

</html>
