<?php

ini_set('display_errors', true);

$sapResponse = '';
$xmlBody = '';

if(!empty($_POST["xmlBody"]))
{
	$xmlBody = $_POST["xmlBody"];

	// allocate curl
	$curl = curl_init('http://212.150.41.90/TestForSite/SapBusinessOne_WebService_InvoiceAndReceipt.asmx');

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
    $xmlBody = '<?xml version="1.0" encoding="UTF-8"?><env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope"><env:Body><CreateInvoiceAndPaymentBaseOnSalesOrder><XmlDoc><Invoice><Header><Field name="SaleOrderReferenceNo">73</Field></Header><Lines><Field name="TaxCode">EX</Field></Lines><PaymentLines><Field name="CreditCompanyCode">6</Field><Field name="CreditCardNumber">2025</Field><Field name="Currency">NIS</Field><Field name="Amount">3</Field><Field name="Payment_Time">2017-09-19 15:30:53</Field><Field name="Gateway">PELECARD</Field><Field name="Credit_exp">12/2019</Field><Field name="Approval_Reference">0000000</Field><Field name="PaymentMethod">1</Field><Field name="VoucherNumber">12345678</Field><Field name="PaymentType">5</Field><Field name="PaidFor">hhhhhh.hhh-1830</Field><Field name="RecurringToken">6091648828</Field><Field name="RecurringMode">month</Field><Field name="keepCCForFuture">true</Field></PaymentLines></Invoice></XmlDoc></CreateInvoiceAndPaymentBaseOnSalesOrder></env:Body></env:Envelope>';
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

