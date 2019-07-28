<?php

/*
|--------------------------------------------------------------------------
| Web Routes For Test Only
|--------------------------------------------------------------------------
*/

Route::get('/testsession', function(){
    echo Session::getId();
});

Route::get('/xmltest', function () {
    $myXMLData = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body><AddBPResponse><AddBPResult>Customer Added Successfully|Ett241249</AddBPResult></AddBPResponse></soap:Body></soap:Envelope>';

    $xmlDoc = new \DOMDocument();
    $xmlDoc->loadXML($myXMLData);

    dd($xmlDoc->getElementsByTagName('AddBPResponse')->item(0)->nodeValue);

    $ret = $xmlDoc->documentElement;

    foreach ($ret->childNodes AS $item) {
        print $item->nodeName . " = " . $item->nodeValue . "<br>";
    }

    dd($ret->childNodes);

    /*
    $doc = new DOMDocument();
    $doc->load( 'books.xml' );

    $books = $doc->getElementsByTagName( "book" );
    foreach( $books as $book )
    {
    $authors = $book->getElementsByTagName( "author" );
    $author = $authors->item(0)->nodeValue;

    $publishers = $book->getElementsByTagName( "publisher" );
    $publisher = $publishers->item(0)->nodeValue;

    $titles = $book->getElementsByTagName( "title" );
    $title = $titles->item(0)->nodeValue;

    echo "$title - $author - $publisher\n";
    }
    */


});


Route::get('testsession1', function(){
    // var_dump(session('myses'));
    //
    // $data = \Request::session()->all();
    //
    // p($data);
    // session(['myses'=>'gggggggggg']);
    // echo 'continue';


    $loggedSessions = new App\LoggedSessions;
    $loggedSessions->session_id = Session::getId();
    $loggedSessions->ip_address = \Request::ip();
    $loggedSessions->user_agent = \Request::server('HTTP_USER_AGENT');
    $loggedSessions->payload = "xx";
    $loggedSessions->last_activity = 123;
    $loggedSessions->user_name = "gdfgdfg";
    $loggedSessions->domain_name = "fsdfas";
    $loggedSessions->login_type = 1;
    $loggedSessions->user_type = 2;
    $loggedSessions->save();
});


Route::get('arrxml', function(){

    $mock = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><GetBPDetailsResponse><GetBPDetailsResult><NewCustomer><Field name="FirstName">ffffffftterwtu</Field><Field name="LastName">tewrtew</Field><Field name="Password">123456</Field><Field name="Email">trete@gdfg.dfs.ggtr</Field><Field name="SecondEmail">ghdfe@gdfs.gdf</Field><Field name="CellNumber">6574673</Field><Field name="AuthCode">NA</Field><Field name="SecondCellNumber">5345654</Field><Field name="FaxNumber">65465346</Field><Field name="StreetAddress">hgfsdhdfj</Field><Field name="City">nmcvnvb</Field><Field name="Zip">6546742</Field><Field name="CompanyName">compgfdsh</Field><Field name="CompanyNumber">5663534</Field><Field name="ContactPerson">hgfhds</Field><Field name="Facebook">hsfs</Field><Field name="State">ncvc</Field><Field name="Country">nxgf</Field><Field name="FirstLogin"></Field><Field name="UpdateFlag"></Field><Field name="UserPref">1</Field></NewCustomer></GetBPDetailsResult></GetBPDetailsResponse></soap:Body></soap:Envelope>';

    $arr = [
        'AuthCode', 'SecondEmail', 'CompanyNumber'
    ];
    $retmock = getXmlByKey($mock, $arr);
    //echo(e($mock));
    //$simple = "<para><note>simple note</note></para>";
    // $p = xml_parser_create();
    // xml_parse_into_struct($p, $simple, $vals, $index);
    // xml_parser_free($p);
    // echo "Index array\n";
    // p($index);
    // echo "\nVals array\n";
    // dd($vals);


    return $retmock;

});

Route::get('testlog', function(){

    logg(__CLASS__ . "\n" . __METHOD__ . "\n" . __FILE__ . ':' . __LINE__ . ";register new user, isexists:", []);

});






Route::get('/xmlservice', function () {

    $url = 'http://212.150.41.90/TestForSite/SapBusinessOne_WebService_Registration.asmx?WSDL';

    $xml = '<?xml version="1.0" encoding="UTF-8"?> <NewCustomer><FirstName>ghfdhgfh</FirstName><LastName>hfghfgh</LastName><Password>123456</Password><Email>ddfghfghfg@gdsgfg.gdfg</Email><CellNumber>+972544432950</CellNumber><AuthCode>487547</AuthCode></NewCustomer></xml>';

    $xml = stripslashes($xml);

    echo $url;
    echo $xml;


    // allocate curl
    $curl = curl_init( $url );

    // initialize curl
    curl_setopt($curl, CURLOPT_HEADER, 				0 );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 		1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 		1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, 			array( "Content-Type: application/soap+xml; charset=utf-8" ) );
    curl_setopt($curl, CURLOPT_POST, 				1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, 			$xml);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 		0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 		0);

    // get data
    $response = curl_exec($curl);

    // close curl
    curl_close($curl);



    dd($response);

});


Route::get('accountlist', 'Auth\LoginController@accountList');
