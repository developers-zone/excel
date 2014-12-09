<?php
// Copyright 2009, FedEx Corporation. All rights reserved.

define('TRANSACTIONS_LOG_FILE', 'fedextransactions.log');  // Transactions log file

/**
 *  Print SOAP request and response
 */
define('Newline',"<br />");

function printSuccess($client, $response) {
    echo '<h2>Transaction Successful</h2>';  
    echo "\n";
    printRequestResponse($client);
}

function printRequestResponse($client){
	echo '<h2>Request</h2>' . "\n";
	echo '<pre>' . htmlspecialchars($client->__getLastRequest()). '</pre>';  
	echo "\n";
   
	echo '<h2>Response</h2>'. "\n";
	echo '<pre>' . htmlspecialchars($client->__getLastResponse()). '</pre>';
	echo "\n";
}

/**
 *  Print SOAP Fault
 */  
function printFault($exception, $client) {
    echo '<h2>Fault</h2>' . "<br>\n";                        
    echo "<b>Code:</b>{$exception->faultcode}<br>\n";
    echo "<b>String:</b>{$exception->faultstring}<br>\n";
    writeToLog($client);
    
    echo '<h2>Request</h2>' . "\n";
	echo '<pre>' . htmlspecialchars($client->__getLastRequest()). '</pre>';  
	echo "\n";
}

/**
 * SOAP request/response logging to a file
 */                                  
function writeToLog($client){  
if (!$logfile = fopen(TRANSACTIONS_LOG_FILE, "a"))
{
   error_func("Cannot open " . TRANSACTIONS_LOG_FILE . " file.\n", 0);
   exit(1);
}

fwrite($logfile, sprintf("\r%s:- %s",date("D M j G:i:s T Y"), $client->__getLastRequest(). "\n\n" . $client->__getLastResponse()));
}

/**
 * This section provides a convenient place to setup many commonly used variables
 * needed for the php sample code to function.
 */
function getProperty($var){
	if($var == 'key') Return 'ldwDg8DKwxJFtv1X'; 
	if($var == 'password') Return 'p7eiXYLIxjqVh2Ybzx7yXdvdG'; 
		
	if($var == 'shipaccount') Return '510087984'; 
	if($var == 'billaccount') Return '510087984'; 
	if($var == 'dutyaccount') Return 'xxx'; 
	if($var == 'freightaccount') Return 'xxx';  
	if($var == 'trackaccount') Return 'xxx'; 

	if($var == 'meter') Return '118586899'; 
		
	if($var == 'shiptimestamp') Return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));

	if($var == 'spodshipdate') Return '2013-05-21';
	if($var == 'serviceshipdate') Return '2013-04-26';

	if($var == 'readydate') Return '2010-05-31T08:44:07';
	if($var == 'closedate') Return date("Y-m-d");

	if($var == 'pickupdate') Return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+5, date("Y")));
	if($var == 'pickuptimestamp') Return mktime(8, 0, 0, date("m")  , date("d")+1, date("Y"));
	if($var == 'pickuplocationid') Return 'XXX';
	if($var == 'pickupconfirmationnumber') Return 'XXX';

	if($var == 'dispatchdate') Return date("Y-m-d", mktime(8, 0, 0, date("m")  , date("d")+1, date("Y")));
	if($var == 'dispatchlocationid') Return 'XXX';
	if($var == 'dispatchconfirmationnumber') Return 'XXX';		
	
	if($var == 'tag_readytimestamp') Return mktime(10, 0, 0, date("m"), date("d")+1, date("Y"));
	if($var == 'tag_latesttimestamp') Return mktime(20, 0, 0, date("m"), date("d")+1, date("Y"));	

	if($var == 'expirationdate') Return '2013-05-24';
	if($var == 'begindate') Return '2013-04-22';
	if($var == 'enddate') Return '2013-04-25';	

	if($var == 'trackingnumber') Return '589920262513';

	if($var == 'hubid') Return 'XXX';
	
	if($var == 'jobid') Return 'XXX';

	if($var == 'searchlocationphonenumber') Return '5555555555';
			
	if($var == 'shipper') Return array(
		'Contact' => array(
			'PersonName' => 'Sender Name',
			'CompanyName' => 'Sender Company Name',
			'PhoneNumber' => '1234567890'
		),
		'Address' => array(
			'StreetLines' => array('Address Line 1'),
			'City' => 'Collierville',
			'StateOrProvinceCode' => 'TN',
			'PostalCode' => '38017',
			'CountryCode' => 'US',
			'Residential' => 1
		)
	);
	if($var == 'recipient') Return array(
		'Contact' => array(
			'PersonName' => 'Recipient Name',
			'CompanyName' => 'Recipient Company Name',
			'PhoneNumber' => '1234567890'
		),
		'Address' => array(
			'StreetLines' => array('Address Line 1'),
			'City' => 'Herndon',
			'StateOrProvinceCode' => 'VA',
			'PostalCode' => '20171',
			'CountryCode' => 'US',
			'Residential' => 1
		)
	);	

	if($var == 'address1') Return array(
		'StreetLines' => array('10 Fed Ex Pkwy'),
		'City' => 'Memphis',
		'StateOrProvinceCode' => 'TN',
		'PostalCode' => '38115',
		'CountryCode' => 'US'
    );
	if($var == 'address2') Return array(
		'StreetLines' => array('13450 Farmcrest Ct'),
		'City' => 'Herndon',
		'StateOrProvinceCode' => 'VA',
		'PostalCode' => '20171',
		'CountryCode' => 'US'
	);					  
	if($var == 'searchlocationsaddress') Return array(
		'StreetLines'=> array('240 Central Park S'),
		'City'=>'Austin',
		'StateOrProvinceCode'=>'TX',
		'PostalCode'=>'78701',
		'CountryCode'=>'US'
	);
									  
	if($var == 'shippingchargespayment') Return array(
		'PaymentType' => 'SENDER',
		'Payor' => array(
			'ResponsibleParty' => array(
				'AccountNumber' => getProperty('billaccount'),
				'Contact' => null,
				'Address' => array('CountryCode' => 'US')
			)
		)
	);	
	if($var == 'freightbilling') Return array(
		'Contact'=>array(
			'ContactId' => 'freight1',
			'PersonName' => 'Big Shipper',
			'Title' => 'Manager',
			'CompanyName' => 'Freight Shipper Co',
			'PhoneNumber' => '1234567890'
		),
		'Address'=>array(
			'StreetLines'=>array(
				'1202 Chalet Ln', 
				'Do Not Delete - Test Account'
			),
			'City' =>'Harrison',
			'StateOrProvinceCode' => 'AR',
			'PostalCode' => '72601-6353',
			'CountryCode' => 'US'
			)
	);
}

function setEndpoint($var){
	if($var == 'changeEndpoint') Return false;
}

function printNotifications($notes){
	foreach($notes as $noteKey => $note){
		if(is_string($note)){    
            echo $noteKey . ': ' . $note . Newline;
        }
        else{
        	printNotifications($note);
        }
	}
	echo Newline;
}

function printError($client, $response){
    echo '<h2>Error returned in processing transaction</h2>';
	echo "\n";
	printNotifications($response -> Notifications);
    printRequestResponse($client, $response);
}

function trackDetails($details, $spacer){
	foreach($details as $key => $value){
		if(is_array($value) || is_object($value)){
        	$newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
    		echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
    		trackDetails($value, $newSpacer);
    	}elseif(empty($value)){
    		echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
    	}else{
    		echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
    	}
    }
}
function getCountryCode($cCode)
{return "US";
	if(strtoupper($cCode) == "AFGHANISTAN") return "AF"; 
	 else
	if(strtoupper($cCode) == "ÅLAND ISLANDS") return "AX"; 
	 else
	if(strtoupper($cCode) == "ALBANIA") return "AL"; 
	 else
	if(strtoupper($cCode) == "ALGERIA") return "DZ"; 
	 else
	if(strtoupper($cCode) == "AMERICAN SAMOA") return "AS"; 
	 else
	if(strtoupper($cCode) == "ANDORRA") return "AD"; 
	 else
	if(strtoupper($cCode) == "ANGOLA") return "AO"; 
	 else
	if(strtoupper($cCode) == "ANGUILLA") return "AI"; 
	 else
	if(strtoupper($cCode) == "ANTARCTICA") return "AQ"; 
	 else
	if(strtoupper($cCode) == "ANTIGUA AND BARBUDA") return "AG"; 
	 else
	if(strtoupper($cCode) == "ARGENTINA") return "AR"; 
	 else
	if(strtoupper($cCode) == "ARMENIA") return "AM"; 
	 else
	if(strtoupper($cCode) == "ARUBA") return "AW"; 
	 else
	if(strtoupper($cCode) == "AUSTRALIA") return "AU"; 
	 else
	if(strtoupper($cCode) == "AUSTRIA") return "AT"; 
	 else
	if(strtoupper($cCode) == "AZERBAIJAN") return "AZ"; 
	 else
	if(strtoupper($cCode) == "BAHAMAS") return "BS"; 
	 else
	if(strtoupper($cCode) == "BAHRAIN") return "BH"; 
	 else
	if(strtoupper($cCode) == "BANGLADESH") return "BD"; 
	 else
	if(strtoupper($cCode) == "BARBADOS") return "BB"; 
	 else
	if(strtoupper($cCode) == "BELARUS") return "BY"; 
	 else
	if(strtoupper($cCode) == "BELGIUM") return "BE"; 
	 else
	if(strtoupper($cCode) == "BELIZE") return "BZ"; 
	 else
	if(strtoupper($cCode) == "BENIN") return "BJ"; 
	 else
	if(strtoupper($cCode) == "BERMUDA") return "BM"; 
	 else
	if(strtoupper($cCode) == "BHUTAN") return "BT"; 
	 else
	if(strtoupper($cCode) == "BOLIVIA, PLURINATIONAL STATE OF") return "BO"; 
	 else
	if(strtoupper($cCode) == "BONAIRE, SINT EUSTATIUS AND SABA") return "BQ"; 
	 else
	if(strtoupper($cCode) == "BOSNIA AND HERZEGOVINA") return "BA"; 
	 else
	if(strtoupper($cCode) == "BOTSWANA") return "BW"; 
	 else
	if(strtoupper($cCode) == "BOUVET ISLAND") return "BV"; 
	 else
	if(strtoupper($cCode) == "BRAZIL") return "BR"; 
	 else
	if(strtoupper($cCode) == "BRITISH INDIAN OCEAN TERRITORY") return "IO"; 
	 else
	if(strtoupper($cCode) == "BRUNEI DARUSSALAM") return "BN"; 
	 else
	if(strtoupper($cCode) == "BULGARIA") return "BG"; 
	 else
	if(strtoupper($cCode) == "BURKINA FASO") return "BF"; 
	 else
	if(strtoupper($cCode) == "BURUNDI") return "BI"; 
	 else
	if(strtoupper($cCode) == "CAMBODIA") return "KH"; 
	 else
	if(strtoupper($cCode) == "CAMEROON") return "CM"; 
	 else
	if(strtoupper($cCode) == "CANADA") return "CA"; 
	 else
	if(strtoupper($cCode) == "CAPE VERDE") return "CV"; 
	 else
	if(strtoupper($cCode) == "CAYMAN ISLANDS") return "KY"; 
	 else
	if(strtoupper($cCode) == "CENTRAL AFRICAN REPUBLIC") return "CF"; 
	 else
	if(strtoupper($cCode) == "CHAD") return "TD"; 
	 else
	if(strtoupper($cCode) == "CHILE") return "CL"; 
	 else
	if(strtoupper($cCode) == "CHINA") return "CN"; 
	 else
	if(strtoupper($cCode) == "CHRISTMAS ISLAND") return "CX"; 
	 else
	if(strtoupper($cCode) == "COCOS (KEELING) ISLANDS") return "CC"; 
	 else
	if(strtoupper($cCode) == "COLOMBIA") return "CO"; 
	 else
	if(strtoupper($cCode) == "COMOROS") return "KM"; 
	 else
	if(strtoupper($cCode) == "CONGO") return "CG"; 
	 else
	if(strtoupper($cCode) == "CONGO, THE DEMOCRATIC REPUBLIC OF THE") return "CD"; 
	 else
	if(strtoupper($cCode) == "COOK ISLANDS") return "CK"; 
	 else
	if(strtoupper($cCode) == "COSTA RICA") return "CR"; 
	 else
	if(strtoupper($cCode) == "CÔTE D'IVOIRE") return "CI"; 
	 else
	if(strtoupper($cCode) == "CROATIA") return "HR"; 
	 else
	if(strtoupper($cCode) == "CUBA") return "CU"; 
	 else
	if(strtoupper($cCode) == "CURAÇAO") return "CW"; 
	 else
	if(strtoupper($cCode) == "CYPRUS") return "CY"; 
	 else
	if(strtoupper($cCode) == "CZECH REPUBLIC") return "CZ"; 
	 else
	if(strtoupper($cCode) == "DENMARK") return "DK"; 
	 else
	if(strtoupper($cCode) == "DJIBOUTI") return "DJ"; 
	 else
	if(strtoupper($cCode) == "DOMINICA") return "DM"; 
	 else
	if(strtoupper($cCode) == "DOMINICAN REPUBLIC") return "DO"; 
	 else
	if(strtoupper($cCode) == "ECUADOR") return "EC"; 
	 else
	if(strtoupper($cCode) == "EGYPT") return "EG"; 
	 else
	if(strtoupper($cCode) == "EL SALVADOR") return "SV"; 
	 else
	if(strtoupper($cCode) == "EQUATORIAL GUINEA") return "GQ"; 
	 else
	if(strtoupper($cCode) == "ERITREA") return "ER"; 
	 else
	if(strtoupper($cCode) == "ESTONIA") return "EE"; 
	 else
	if(strtoupper($cCode) == "ETHIOPIA") return "ET"; 
	 else
	if(strtoupper($cCode) == "FALKLAND ISLANDS (MALVINAS)") return "FK"; 
	 else
	if(strtoupper($cCode) == "FAROE ISLANDS") return "FO"; 
	 else
	if(strtoupper($cCode) == "FIJI") return "FJ"; 
	 else
	if(strtoupper($cCode) == "FINLAND") return "FI"; 
	 else
	if(strtoupper($cCode) == "FRANCE") return "FR"; 
	 else
	if(strtoupper($cCode) == "FRENCH GUIANA") return "GF"; 
	 else
	if(strtoupper($cCode) == "FRENCH POLYNESIA") return "PF"; 
	 else
	if(strtoupper($cCode) == "FRENCH SOUTHERN TERRITORIES") return "TF"; 
	 else
	if(strtoupper($cCode) == "GABON") return "GA"; 
	 else
	if(strtoupper($cCode) == "GAMBIA") return "GM"; 
	 else
	if(strtoupper($cCode) == "GEORGIA") return "GE"; 
	 else
	if(strtoupper($cCode) == "GERMANY") return "DE"; 
	 else
	if(strtoupper($cCode) == "GHANA") return "GH"; 
	 else
	if(strtoupper($cCode) == "GIBRALTAR") return "GI"; 
	 else
	if(strtoupper($cCode) == "GREECE") return "GR"; 
	 else
	if(strtoupper($cCode) == "GREENLAND") return "GL"; 
	 else
	if(strtoupper($cCode) == "GRENADA") return "GD"; 
	 else
	if(strtoupper($cCode) == "GUADELOUPE") return "GP"; 
	 else
	if(strtoupper($cCode) == "GUAM") return "GU"; 
	 else
	if(strtoupper($cCode) == "GUATEMALA") return "GT"; 
	 else
	if(strtoupper($cCode) == "GUERNSEY") return "GG"; 
	 else
	if(strtoupper($cCode) == "GUINEA") return "GN"; 
	 else
	if(strtoupper($cCode) == "GUINEA-BISSAU") return "GW"; 
	 else
	if(strtoupper($cCode) == "GUYANA") return "GY"; 
	 else
	if(strtoupper($cCode) == "HAITI") return "HT"; 
	 else
	if(strtoupper($cCode) == "HEARD ISLAND AND MCDONALD ISLANDS") return "HM"; 
	 else
	if(strtoupper($cCode) == "HOLY SEE (VATICAN CITY STATE)") return "VA"; 
	 else
	if(strtoupper($cCode) == "HONDURAS") return "HN"; 
	 else
	if(strtoupper($cCode) == "HONG KONG") return "HK"; 
	 else
	if(strtoupper($cCode) == "HUNGARY") return "HU"; 
	 else
	if(strtoupper($cCode) == "ICELAND") return "IS"; 
	 else
	if(strtoupper($cCode) == "INDIA") return "IN"; 
	 else
	if(strtoupper($cCode) == "INDONESIA") return "ID"; 
	 else
	if(strtoupper($cCode) == "IRAN, ISLAMIC REPUBLIC OF") return "IR"; 
	 else
	if(strtoupper($cCode) == "IRAQ") return "IQ"; 
	 else
	if(strtoupper($cCode) == "IRELAND") return "IE"; 
	 else
	if(strtoupper($cCode) == "ISLE OF MAN") return "IM"; 
	 else
	if(strtoupper($cCode) == "ISRAEL") return "IL"; 
	 else
	if(strtoupper($cCode) == "ITALY") return "IT"; 
	 else
	if(strtoupper($cCode) == "JAMAICA") return "JM"; 
	 else
	if(strtoupper($cCode) == "JAPAN") return "JP"; 
	 else
	if(strtoupper($cCode) == "JERSEY") return "JE"; 
	 else
	if(strtoupper($cCode) == "JORDAN") return "JO"; 
	 else
	if(strtoupper($cCode) == "KAZAKHSTAN") return "KZ"; 
	 else
	if(strtoupper($cCode) == "KENYA") return "KE"; 
	 else
	if(strtoupper($cCode) == "KIRIBATI") return "KI"; 
	 else
	if(strtoupper($cCode) == "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF") return "KP"; 
	 else
	if(strtoupper($cCode) == "KOREA, REPUBLIC OF") return "KR"; 
	 else
	if(strtoupper($cCode) == "KUWAIT") return "KW"; 
	 else
	if(strtoupper($cCode) == "KYRGYZSTAN") return "KG"; 
	 else
	if(strtoupper($cCode) == "LAO PEOPLE'S DEMOCRATIC REPUBLIC") return "LA"; 
	 else
	if(strtoupper($cCode) == "LATVIA") return "LV"; 
	 else
	if(strtoupper($cCode) == "LEBANON") return "LB"; 
	 else
	if(strtoupper($cCode) == "LESOTHO") return "LS"; 
	 else
	if(strtoupper($cCode) == "LIBERIA") return "LR"; 
	 else
	if(strtoupper($cCode) == "LIBYA") return "LY"; 
	 else
	if(strtoupper($cCode) == "LIECHTENSTEIN") return "LI"; 
	 else
	if(strtoupper($cCode) == "LITHUANIA") return "LT"; 
	 else
	if(strtoupper($cCode) == "LUXEMBOURG") return "LU"; 
	 else
	if(strtoupper($cCode) == "MACAO") return "MO"; 
	 else
	if(strtoupper($cCode) == "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF") return "MK"; 
	 else
	if(strtoupper($cCode) == "MADAGASCAR") return "MG"; 
	 else
	if(strtoupper($cCode) == "MALAWI") return "MW"; 
	 else
	if(strtoupper($cCode) == "MALAYSIA") return "MY"; 
	 else
	if(strtoupper($cCode) == "MALDIVES") return "MV"; 
	 else
	if(strtoupper($cCode) == "MALI") return "ML"; 
	 else
	if(strtoupper($cCode) == "MALTA") return "MT"; 
	 else
	if(strtoupper($cCode) == "MARSHALL ISLANDS") return "MH"; 
	 else
	if(strtoupper($cCode) == "MARTINIQUE") return "MQ"; 
	 else
	if(strtoupper($cCode) == "MAURITANIA") return "MR"; 
	 else
	if(strtoupper($cCode) == "MAURITIUS") return "MU"; 
	 else
	if(strtoupper($cCode) == "MAYOTTE") return "YT"; 
	 else
	if(strtoupper($cCode) == "MEXICO") return "MX"; 
	 else
	if(strtoupper($cCode) == "MICRONESIA, FEDERATED STATES OF") return "FM"; 
	 else
	if(strtoupper($cCode) == "MOLDOVA, REPUBLIC OF") return "MD"; 
	 else
	if(strtoupper($cCode) == "MONACO") return "MC"; 
	 else
	if(strtoupper($cCode) == "MONGOLIA") return "MN"; 
	 else
	if(strtoupper($cCode) == "MONTENEGRO") return "ME"; 
	 else
	if(strtoupper($cCode) == "MONTSERRAT") return "MS"; 
	 else
	if(strtoupper($cCode) == "MOROCCO") return "MA"; 
	 else
	if(strtoupper($cCode) == "MOZAMBIQUE") return "MZ"; 
	 else
	if(strtoupper($cCode) == "MYANMAR") return "MM"; 
	 else
	if(strtoupper($cCode) == "NAMIBIA") return "NA"; 
	 else
	if(strtoupper($cCode) == "NAURU") return "NR"; 
	 else
	if(strtoupper($cCode) == "NEPAL") return "NP"; 
	 else
	if(strtoupper($cCode) == "NETHERLANDS") return "NL"; 
	 else
	if(strtoupper($cCode) == "NEW CALEDONIA") return "NC"; 
	 else
	if(strtoupper($cCode) == "NEW ZEALAND") return "NZ"; 
	 else
	if(strtoupper($cCode) == "NICARAGUA") return "NI"; 
	 else
	if(strtoupper($cCode) == "NIGER") return "NE"; 
	 else
	if(strtoupper($cCode) == "NIGERIA") return "NG"; 
	 else
	if(strtoupper($cCode) == "NIUE") return "NU"; 
	 else
	if(strtoupper($cCode) == "NORFOLK ISLAND") return "NF"; 
	 else
	if(strtoupper($cCode) == "NORTHERN MARIANA ISLANDS") return "MP"; 
	 else
	if(strtoupper($cCode) == "NORWAY") return "NO"; 
	 else
	if(strtoupper($cCode) == "OMAN") return "OM"; 
	 else
	if(strtoupper($cCode) == "PAKISTAN") return "PK"; 
	 else
	if(strtoupper($cCode) == "PALAU") return "PW"; 
	 else
	if(strtoupper($cCode) == "PALESTINE, STATE OF") return "PS"; 
	 else
	if(strtoupper($cCode) == "PANAMA") return "PA"; 
	 else
	if(strtoupper($cCode) == "PAPUA NEW GUINEA") return "PG"; 
	 else
	if(strtoupper($cCode) == "PARAGUAY") return "PY"; 
	 else
	if(strtoupper($cCode) == "PERU") return "PE"; 
	 else
	if(strtoupper($cCode) == "PHILIPPINES") return "PH"; 
	 else
	if(strtoupper($cCode) == "PITCAIRN") return "PN"; 
	 else
	if(strtoupper($cCode) == "POLAND") return "PL"; 
	 else
	if(strtoupper($cCode) == "PORTUGAL") return "PT"; 
	 else
	if(strtoupper($cCode) == "PUERTO RICO") return "PR"; 
	 else
	if(strtoupper($cCode) == "QATAR") return "QA"; 
	 else
	if(strtoupper($cCode) == "RÉUNION") return "RE"; 
	 else
	if(strtoupper($cCode) == "ROMANIA") return "RO"; 
	 else
	if(strtoupper($cCode) == "RUSSIAN FEDERATION") return "RU"; 
	 else
	if(strtoupper($cCode) == "RWANDA") return "RW"; 
	 else
	if(strtoupper($cCode) == "SAINT BARTHÉLEMY") return "BL"; 
	 else
	if(strtoupper($cCode) == "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA") return "SH"; 
	 else
	if(strtoupper($cCode) == "SAINT KITTS AND NEVIS") return "KN"; 
	 else
	if(strtoupper($cCode) == "SAINT LUCIA") return "LC"; 
	 else
	if(strtoupper($cCode) == "SAINT MARTIN (FRENCH PART)") return "MF"; 
	 else
	if(strtoupper($cCode) == "SAINT PIERRE AND MIQUELON") return "PM"; 
	 else
	if(strtoupper($cCode) == "SAINT VINCENT AND THE GRENADINES") return "VC"; 
	 else
	if(strtoupper($cCode) == "SAMOA") return "WS"; 
	 else
	if(strtoupper($cCode) == "SAN MARINO") return "SM"; 
	 else
	if(strtoupper($cCode) == "SAO TOME AND PRINCIPE") return "ST"; 
	 else
	if(strtoupper($cCode) == "SAUDI ARABIA") return "SA"; 
	 else
	if(strtoupper($cCode) == "SENEGAL") return "SN"; 
	 else
	if(strtoupper($cCode) == "SERBIA") return "RS"; 
	 else
	if(strtoupper($cCode) == "SEYCHELLES") return "SC"; 
	 else
	if(strtoupper($cCode) == "SIERRA LEONE") return "SL"; 
	 else
	if(strtoupper($cCode) == "SINGAPORE") return "SG"; 
	 else
	if(strtoupper($cCode) == "SINT MAARTEN (DUTCH PART)") return "SX"; 
	 else
	if(strtoupper($cCode) == "SLOVAKIA") return "SK"; 
	 else
	if(strtoupper($cCode) == "SLOVENIA") return "SI"; 
	 else
	if(strtoupper($cCode) == "SOLOMON ISLANDS") return "SB"; 
	 else
	if(strtoupper($cCode) == "SOMALIA") return "SO"; 
	 else
	if(strtoupper($cCode) == "SOUTH AFRICA") return "ZA"; 
	 else
	if(strtoupper($cCode) == "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS") return "GS"; 
	 else
	if(strtoupper($cCode) == "SOUTH SUDAN") return "SS"; 
	 else
	if(strtoupper($cCode) == "SPAIN") return "ES"; 
	 else
	if(strtoupper($cCode) == "SRI LANKA") return "LK"; 
	 else
	if(strtoupper($cCode) == "SUDAN") return "SD"; 
	 else
	if(strtoupper($cCode) == "SURINAME") return "SR"; 
	 else
	if(strtoupper($cCode) == "SVALBARD AND JAN MAYEN") return "SJ"; 
	 else
	if(strtoupper($cCode) == "SWAZILAND") return "SZ"; 
	 else
	if(strtoupper($cCode) == "SWEDEN") return "SE"; 
	 else
	if(strtoupper($cCode) == "SWITZERLAND") return "CH"; 
	 else
	if(strtoupper($cCode) == "SYRIAN ARAB REPUBLIC") return "SY"; 
	 else
	if(strtoupper($cCode) == "TAIWAN, PROVINCE OF CHINA") return "TW"; 
	 else
	if(strtoupper($cCode) == "TAJIKISTAN") return "TJ"; 
	 else
	if(strtoupper($cCode) == "TANZANIA, UNITED REPUBLIC OF") return "TZ"; 
	 else
	if(strtoupper($cCode) == "THAILAND") return "TH"; 
	 else
	if(strtoupper($cCode) == "TIMOR-LESTE") return "TL"; 
	 else
	if(strtoupper($cCode) == "TOGO") return "TG"; 
	 else
	if(strtoupper($cCode) == "TOKELAU") return "TK"; 
	 else
	if(strtoupper($cCode) == "TONGA") return "TO"; 
	 else
	if(strtoupper($cCode) == "TRINIDAD AND TOBAGO") return "TT"; 
	 else
	if(strtoupper($cCode) == "TUNISIA") return "TN"; 
	 else
	if(strtoupper($cCode) == "TURKEY") return "TR"; 
	 else
	if(strtoupper($cCode) == "TURKMENISTAN") return "TM"; 
	 else
	if(strtoupper($cCode) == "TURKS AND CAICOS ISLANDS") return "TC"; 
	 else
	if(strtoupper($cCode) == "TUVALU") return "TV"; 
	 else
	if(strtoupper($cCode) == "UGANDA") return "UG"; 
	 else
	if(strtoupper($cCode) == "UKRAINE") return "UA"; 
	 else
	if(strtoupper($cCode) == "UNITED ARAB EMIRATES") return "AE"; 
	 else
	if(strtoupper($cCode) == "UNITED KINGDOM") return "GB"; 
	 else
	if(strtoupper($cCode) == "UNITED STATES") return "US"; 
	 else
	if(strtoupper($cCode) == "UNITED STATES MINOR OUTLYING ISLANDS") return "UM"; 
	 else
	if(strtoupper($cCode) == "URUGUAY") return "UY"; 
	 else
	if(strtoupper($cCode) == "UZBEKISTAN") return "UZ"; 
	 else
	if(strtoupper($cCode) == "VANUATU") return "VU"; 
	 else
	if(strtoupper($cCode) == "VENEZUELA, BOLIVARIAN REPUBLIC OF") return "VE"; 
	 else
	if(strtoupper($cCode) == "VIET NAM") return "VN"; 
	 else
	if(strtoupper($cCode) == "VIRGIN ISLANDS, BRITISH") return "VG"; 
	 else
	if(strtoupper($cCode) == "VIRGIN ISLANDS, U.S.") return "VI"; 
	 else
	if(strtoupper($cCode) == "WALLIS AND FUTUNA") return "WF"; 
	 else
	if(strtoupper($cCode) == "WESTERN SAHARA") return "EH"; 
	 else
	if(strtoupper($cCode) == "YEMEN") return "YE"; 
	 else
	if(strtoupper($cCode) == "ZAMBIA") return "ZM"; 
	 else
	if(strtoupper($cCode) == "ZIMBABWE") return "ZW"; 
	 else
	return strtoupper($cCode);
}

function getCountryList()
{
	
	$arrCountry[0] = "AFGHANISTAN"; $arrCountryCode[0]="AF";
	$arrCountry[1] = "ÅLAND ISLANDS"; $arrCountryCode[1]="AX";
	$arrCountry[2] = "ALBANIA"; $arrCountryCode[2]="AL";
	$arrCountry[3] = "ALGERIA"; $arrCountryCode[3]="DZ";
	$arrCountry[4] = "AMERICAN SAMOA"; $arrCountryCode[4]="AS";
	$arrCountry[5] = "ANDORRA"; $arrCountryCode[5]="AD";
	$arrCountry[6] = "ANGOLA"; $arrCountryCode[6]="AO";
	$arrCountry[7] = "ANGUILLA"; $arrCountryCode[7]="AI";
	$arrCountry[8] = "ANTARCTICA"; $arrCountryCode[8]="AQ";
	$arrCountry[9] = "ANTIGUA AND BARBUDA"; $arrCountryCode[9]="AG";
	$arrCountry[10] = "ARGENTINA"; $arrCountryCode[10]="AR";
	$arrCountry[11] = "ARMENIA"; $arrCountryCode[11]="AM";
	$arrCountry[12] = "ARUBA"; $arrCountryCode[12]="AW";
	$arrCountry[13] = "AUSTRALIA"; $arrCountryCode[13]="AU";
	$arrCountry[14] = "AUSTRIA"; $arrCountryCode[14]="AT";
	$arrCountry[15] = "AZERBAIJAN"; $arrCountryCode[15]="AZ";
	$arrCountry[16] = "BAHAMAS"; $arrCountryCode[16]="BS";
	$arrCountry[17] = "BAHRAIN"; $arrCountryCode[17]="BH";
	$arrCountry[18] = "BANGLADESH"; $arrCountryCode[18]="BD";
	$arrCountry[19] = "BARBADOS"; $arrCountryCode[19]="BB";
	$arrCountry[20] = "BELARUS"; $arrCountryCode[20]="BY";
	$arrCountry[21] = "BELGIUM"; $arrCountryCode[21]="BE";
	$arrCountry[22] = "BELIZE"; $arrCountryCode[22]="BZ";
	$arrCountry[23] = "BENIN"; $arrCountryCode[23]="BJ";
	$arrCountry[24] = "BERMUDA"; $arrCountryCode[24]="BM";
	$arrCountry[25] = "BHUTAN"; $arrCountryCode[25]="BT";
	$arrCountry[26] = "BOLIVIA, PLURINATIONAL STATE OF"; $arrCountryCode[26]="BO";
	$arrCountry[27] = "BONAIRE, SINT EUSTATIUS AND SABA"; $arrCountryCode[27]="BQ";
	$arrCountry[28] = "BOSNIA AND HERZEGOVINA"; $arrCountryCode[28]="BA";
	$arrCountry[29] = "BOTSWANA"; $arrCountryCode[29]="BW";
	$arrCountry[30] = "BOUVET ISLAND"; $arrCountryCode[30]="BV";
	$arrCountry[31] = "BRAZIL"; $arrCountryCode[31]="BR";
	$arrCountry[32] = "BRITISH INDIAN OCEAN TERRITORY"; $arrCountryCode[32]="IO";
	$arrCountry[33] = "BRUNEI DARUSSALAM"; $arrCountryCode[33]="BN";
	$arrCountry[34] = "BULGARIA"; $arrCountryCode[34]="BG";
	$arrCountry[35] = "BURKINA FASO"; $arrCountryCode[35]="BF";
	$arrCountry[36] = "BURUNDI"; $arrCountryCode[36]="BI";
	$arrCountry[37] = "CAMBODIA"; $arrCountryCode[37]="KH";
	$arrCountry[38] = "CAMEROON"; $arrCountryCode[38]="CM";
	$arrCountry[39] = "CANADA"; $arrCountryCode[39]="CA";
	$arrCountry[40] = "CAPE VERDE"; $arrCountryCode[40]="CV";
	$arrCountry[41] = "CAYMAN ISLANDS"; $arrCountryCode[41]="KY";
	$arrCountry[42] = "CENTRAL AFRICAN REPUBLIC"; $arrCountryCode[42]="CF";
	$arrCountry[43] = "CHAD"; $arrCountryCode[43]="TD";
	$arrCountry[44] = "CHILE"; $arrCountryCode[44]="CL";
	$arrCountry[45] = "CHINA"; $arrCountryCode[45]="CN";
	$arrCountry[46] = "CHRISTMAS ISLAND"; $arrCountryCode[46]="CX";
	$arrCountry[47] = "COCOS (KEELING) ISLANDS"; $arrCountryCode[47]="CC";
	$arrCountry[48] = "COLOMBIA"; $arrCountryCode[48]="CO";
	$arrCountry[49] = "COMOROS"; $arrCountryCode[49]="KM";
	$arrCountry[50] = "CONGO"; $arrCountryCode[50]="CG";
	$arrCountry[51] = "CONGO, THE DEMOCRATIC REPUBLIC OF THE"; $arrCountryCode[51]="CD";
	$arrCountry[52] = "COOK ISLANDS"; $arrCountryCode[52]="CK";
	$arrCountry[53] = "COSTA RICA"; $arrCountryCode[53]="CR";
	$arrCountry[54] = "CÔTE D'IVOIRE"; $arrCountryCode[54]="CI";
	$arrCountry[55] = "CROATIA"; $arrCountryCode[55]="HR";
	$arrCountry[56] = "CUBA"; $arrCountryCode[56]="CU";
	$arrCountry[57] = "CURAÇAO"; $arrCountryCode[57]="CW";
	$arrCountry[58] = "CYPRUS"; $arrCountryCode[58]="CY";
	$arrCountry[59] = "CZECH REPUBLIC"; $arrCountryCode[59]="CZ";
	$arrCountry[60] = "DENMARK"; $arrCountryCode[60]="DK";
	$arrCountry[61] = "DJIBOUTI"; $arrCountryCode[61]="DJ";
	$arrCountry[62] = "DOMINICA"; $arrCountryCode[62]="DM";
	$arrCountry[63] = "DOMINICAN REPUBLIC"; $arrCountryCode[63]="DO";
	$arrCountry[64] = "ECUADOR"; $arrCountryCode[64]="EC";
	$arrCountry[65] = "EGYPT"; $arrCountryCode[65]="EG";
	$arrCountry[66] = "EL SALVADOR"; $arrCountryCode[66]="SV";
	$arrCountry[67] = "EQUATORIAL GUINEA"; $arrCountryCode[67]="GQ";
	$arrCountry[68] = "ERITREA"; $arrCountryCode[68]="ER";
	$arrCountry[69] = "ESTONIA"; $arrCountryCode[69]="EE";
	$arrCountry[70] = "ETHIOPIA"; $arrCountryCode[70]="ET";
	$arrCountry[71] = "FALKLAND ISLANDS (MALVINAS)"; $arrCountryCode[71]="FK";
	$arrCountry[72] = "FAROE ISLANDS"; $arrCountryCode[72]="FO";
	$arrCountry[73] = "FIJI"; $arrCountryCode[73]="FJ";
	$arrCountry[74] = "FINLAND"; $arrCountryCode[74]="FI";
	$arrCountry[75] = "FRANCE"; $arrCountryCode[75]="FR";
	$arrCountry[76] = "FRENCH GUIANA"; $arrCountryCode[76]="GF";
	$arrCountry[77] = "FRENCH POLYNESIA"; $arrCountryCode[77]="PF";
	$arrCountry[78] = "FRENCH SOUTHERN TERRITORIES"; $arrCountryCode[78]="TF";
	$arrCountry[79] = "GABON"; $arrCountryCode[79]="GA";
	$arrCountry[80] = "GAMBIA"; $arrCountryCode[80]="GM";
	$arrCountry[81] = "GEORGIA"; $arrCountryCode[81]="GE";
	$arrCountry[82] = "GERMANY"; $arrCountryCode[82]="DE";
	$arrCountry[83] = "GHANA"; $arrCountryCode[83]="GH";
	$arrCountry[84] = "GIBRALTAR"; $arrCountryCode[84]="GI";
	$arrCountry[85] = "GREECE"; $arrCountryCode[85]="GR";
	$arrCountry[86] = "GREENLAND"; $arrCountryCode[86]="GL";
	$arrCountry[87] = "GRENADA"; $arrCountryCode[87]="GD";
	$arrCountry[88] = "GUADELOUPE"; $arrCountryCode[88]="GP";
	$arrCountry[89] = "GUAM"; $arrCountryCode[89]="GU";
	$arrCountry[90] = "GUATEMALA"; $arrCountryCode[90]="GT";
	$arrCountry[91] = "GUERNSEY"; $arrCountryCode[91]="GG";
	$arrCountry[92] = "GUINEA"; $arrCountryCode[92]="GN";
	$arrCountry[93] = "GUINEA-BISSAU"; $arrCountryCode[93]="GW";
	$arrCountry[94] = "GUYANA"; $arrCountryCode[94]="GY";
	$arrCountry[95] = "HAITI"; $arrCountryCode[95]="HT";
	$arrCountry[96] = "HEARD ISLAND AND MCDONALD ISLANDS"; $arrCountryCode[96]="HM";
	$arrCountry[97] = "HOLY SEE (VATICAN CITY STATE)"; $arrCountryCode[97]="VA";
	$arrCountry[98] = "HONDURAS"; $arrCountryCode[98]="HN";
	$arrCountry[99] = "HONG KONG"; $arrCountryCode[99]="HK";
	$arrCountry[100] = "HUNGARY"; $arrCountryCode[100]="HU";
	$arrCountry[101] = "ICELAND"; $arrCountryCode[101]="IS";
	$arrCountry[102] = "INDIA"; $arrCountryCode[102]="IN";
	$arrCountry[103] = "INDONESIA"; $arrCountryCode[103]="ID";
	$arrCountry[104] = "IRAN, ISLAMIC REPUBLIC OF"; $arrCountryCode[104]="IR";
	$arrCountry[105] = "IRAQ"; $arrCountryCode[105]="IQ";
	$arrCountry[106] = "IRELAND"; $arrCountryCode[106]="IE";
	$arrCountry[107] = "ISLE OF MAN"; $arrCountryCode[107]="IM";
	$arrCountry[108] = "ISRAEL"; $arrCountryCode[108]="IL";
	$arrCountry[109] = "ITALY"; $arrCountryCode[109]="IT";
	$arrCountry[110] = "JAMAICA"; $arrCountryCode[110]="JM";
	$arrCountry[111] = "JAPAN"; $arrCountryCode[111]="JP";
	$arrCountry[112] = "JERSEY"; $arrCountryCode[112]="JE";
	$arrCountry[113] = "JORDAN"; $arrCountryCode[113]="JO";
	$arrCountry[114] = "KAZAKHSTAN"; $arrCountryCode[114]="KZ";
	$arrCountry[115] = "KENYA"; $arrCountryCode[115]="KE";
	$arrCountry[116] = "KIRIBATI"; $arrCountryCode[116]="KI";
	$arrCountry[117] = "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF"; $arrCountryCode[117]="KP";
	$arrCountry[118] = "KOREA, REPUBLIC OF"; $arrCountryCode[118]="KR";
	$arrCountry[119] = "KUWAIT"; $arrCountryCode[119]="KW";
	$arrCountry[120] = "KYRGYZSTAN"; $arrCountryCode[120]="KG";
	$arrCountry[121] = "LAO PEOPLE'S DEMOCRATIC REPUBLIC"; $arrCountryCode[121]="LA";
	$arrCountry[122] = "LATVIA"; $arrCountryCode[122]="LV";
	$arrCountry[123] = "LEBANON"; $arrCountryCode[123]="LB";
	$arrCountry[124] = "LESOTHO"; $arrCountryCode[124]="LS";
	$arrCountry[125] = "LIBERIA"; $arrCountryCode[125]="LR";
	$arrCountry[126] = "LIBYA"; $arrCountryCode[126]="LY";
	$arrCountry[127] = "LIECHTENSTEIN"; $arrCountryCode[127]="LI";
	$arrCountry[128] = "LITHUANIA"; $arrCountryCode[128]="LT";
	$arrCountry[129] = "LUXEMBOURG"; $arrCountryCode[129]="LU";
	$arrCountry[130] = "MACAO"; $arrCountryCode[130]="MO";
	$arrCountry[131] = "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF"; $arrCountryCode[131]="MK";
	$arrCountry[132] = "MADAGASCAR"; $arrCountryCode[132]="MG";
	$arrCountry[133] = "MALAWI"; $arrCountryCode[133]="MW";
	$arrCountry[134] = "MALAYSIA"; $arrCountryCode[134]="MY";
	$arrCountry[135] = "MALDIVES"; $arrCountryCode[135]="MV";
	$arrCountry[136] = "MALI"; $arrCountryCode[136]="ML";
	$arrCountry[137] = "MALTA"; $arrCountryCode[137]="MT";
	$arrCountry[138] = "MARSHALL ISLANDS"; $arrCountryCode[138]="MH";
	$arrCountry[139] = "MARTINIQUE"; $arrCountryCode[139]="MQ";
	$arrCountry[140] = "MAURITANIA"; $arrCountryCode[140]="MR";
	$arrCountry[141] = "MAURITIUS"; $arrCountryCode[141]="MU";
	$arrCountry[142] = "MAYOTTE"; $arrCountryCode[142]="YT";
	$arrCountry[143] = "MEXICO"; $arrCountryCode[143]="MX";
	$arrCountry[144] = "MICRONESIA, FEDERATED STATES OF"; $arrCountryCode[144]="FM";
	$arrCountry[145] = "MOLDOVA, REPUBLIC OF"; $arrCountryCode[145]="MD";
	$arrCountry[146] = "MONACO"; $arrCountryCode[146]="MC";
	$arrCountry[147] = "MONGOLIA"; $arrCountryCode[147]="MN";
	$arrCountry[148] = "MONTENEGRO"; $arrCountryCode[148]="ME";
	$arrCountry[149] = "MONTSERRAT"; $arrCountryCode[149]="MS";
	$arrCountry[150] = "MOROCCO"; $arrCountryCode[150]="MA";
	$arrCountry[151] = "MOZAMBIQUE"; $arrCountryCode[151]="MZ";
	$arrCountry[152] = "MYANMAR"; $arrCountryCode[152]="MM";
	$arrCountry[153] = "NAMIBIA"; $arrCountryCode[153]="NA";
	$arrCountry[154] = "NAURU"; $arrCountryCode[154]="NR";
	$arrCountry[155] = "NEPAL"; $arrCountryCode[155]="NP";
	$arrCountry[156] = "NETHERLANDS"; $arrCountryCode[156]="NL";
	$arrCountry[157] = "NEW CALEDONIA"; $arrCountryCode[157]="NC";
	$arrCountry[158] = "NEW ZEALAND"; $arrCountryCode[158]="NZ";
	$arrCountry[159] = "NICARAGUA"; $arrCountryCode[159]="NI";
	$arrCountry[160] = "NIGER"; $arrCountryCode[160]="NE";
	$arrCountry[161] = "NIGERIA"; $arrCountryCode[161]="NG";
	$arrCountry[162] = "NIUE"; $arrCountryCode[162]="NU";
	$arrCountry[163] = "NORFOLK ISLAND"; $arrCountryCode[163]="NF";
	$arrCountry[164] = "NORTHERN MARIANA ISLANDS"; $arrCountryCode[164]="MP";
	$arrCountry[165] = "NORWAY"; $arrCountryCode[165]="NO";
	$arrCountry[166] = "OMAN"; $arrCountryCode[166]="OM";
	$arrCountry[167] = "PAKISTAN"; $arrCountryCode[167]="PK";
	$arrCountry[168] = "PALAU"; $arrCountryCode[168]="PW";
	$arrCountry[169] = "PALESTINE, STATE OF"; $arrCountryCode[169]="PS";
	$arrCountry[170] = "PANAMA"; $arrCountryCode[170]="PA";
	$arrCountry[171] = "PAPUA NEW GUINEA"; $arrCountryCode[171]="PG";
	$arrCountry[172] = "PARAGUAY"; $arrCountryCode[172]="PY";
	$arrCountry[173] = "PERU"; $arrCountryCode[173]="PE";
	$arrCountry[174] = "PHILIPPINES"; $arrCountryCode[174]="PH";
	$arrCountry[175] = "PITCAIRN"; $arrCountryCode[175]="PN";
	$arrCountry[176] = "POLAND"; $arrCountryCode[176]="PL";
	$arrCountry[177] = "PORTUGAL"; $arrCountryCode[177]="PT";
	$arrCountry[178] = "PUERTO RICO"; $arrCountryCode[178]="PR";
	$arrCountry[179] = "QATAR"; $arrCountryCode[179]="QA";
	$arrCountry[180] = "RÉUNION"; $arrCountryCode[180]="RE";
	$arrCountry[181] = "ROMANIA"; $arrCountryCode[181]="RO";
	$arrCountry[182] = "RUSSIAN FEDERATION"; $arrCountryCode[182]="RU";
	$arrCountry[183] = "RWANDA"; $arrCountryCode[183]="RW";
	$arrCountry[184] = "SAINT BARTHÉLEMY"; $arrCountryCode[184]="BL";
	$arrCountry[185] = "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA"; $arrCountryCode[185]="SH";
	$arrCountry[186] = "SAINT KITTS AND NEVIS"; $arrCountryCode[186]="KN";
	$arrCountry[187] = "SAINT LUCIA"; $arrCountryCode[187]="LC";
	$arrCountry[188] = "SAINT MARTIN (FRENCH PART)"; $arrCountryCode[188]="MF";
	$arrCountry[189] = "SAINT PIERRE AND MIQUELON"; $arrCountryCode[189]="PM";
	$arrCountry[190] = "SAINT VINCENT AND THE GRENADINES"; $arrCountryCode[190]="VC";
	$arrCountry[191] = "SAMOA"; $arrCountryCode[191]="WS";
	$arrCountry[192] = "SAN MARINO"; $arrCountryCode[192]="SM";
	$arrCountry[193] = "SAO TOME AND PRINCIPE"; $arrCountryCode[193]="ST";
	$arrCountry[194] = "SAUDI ARABIA"; $arrCountryCode[194]="SA";
	$arrCountry[195] = "SENEGAL"; $arrCountryCode[195]="SN";
	$arrCountry[196] = "SERBIA"; $arrCountryCode[196]="RS";
	$arrCountry[197] = "SEYCHELLES"; $arrCountryCode[197]="SC";
	$arrCountry[198] = "SIERRA LEONE"; $arrCountryCode[198]="SL";
	$arrCountry[199] = "SINGAPORE"; $arrCountryCode[199]="SG";
	$arrCountry[200] = "SINT MAARTEN (DUTCH PART)"; $arrCountryCode[200]="SX";
	$arrCountry[201] = "SLOVAKIA"; $arrCountryCode[201]="SK";
	$arrCountry[202] = "SLOVENIA"; $arrCountryCode[202]="SI";
	$arrCountry[203] = "SOLOMON ISLANDS"; $arrCountryCode[203]="SB";
	$arrCountry[204] = "SOMALIA"; $arrCountryCode[204]="SO";
	$arrCountry[205] = "SOUTH AFRICA"; $arrCountryCode[205]="ZA";
	$arrCountry[206] = "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS"; $arrCountryCode[206]="GS";
	$arrCountry[207] = "SOUTH SUDAN"; $arrCountryCode[207]="SS";
	$arrCountry[208] = "SPAIN"; $arrCountryCode[208]="ES";
	$arrCountry[209] = "SRI LANKA"; $arrCountryCode[209]="LK";
	$arrCountry[210] = "SUDAN"; $arrCountryCode[210]="SD";
	$arrCountry[211] = "SURINAME"; $arrCountryCode[211]="SR";
	$arrCountry[212] = "SVALBARD AND JAN MAYEN"; $arrCountryCode[212]="SJ";
	$arrCountry[213] = "SWAZILAND"; $arrCountryCode[213]="SZ";
	$arrCountry[214] = "SWEDEN"; $arrCountryCode[214]="SE";
	$arrCountry[215] = "SWITZERLAND"; $arrCountryCode[215]="CH";
	$arrCountry[216] = "SYRIAN ARAB REPUBLIC"; $arrCountryCode[216]="SY";
	$arrCountry[217] = "TAIWAN, PROVINCE OF CHINA"; $arrCountryCode[217]="TW";
	$arrCountry[218] = "TAJIKISTAN"; $arrCountryCode[218]="TJ";
	$arrCountry[219] = "TANZANIA, UNITED REPUBLIC OF"; $arrCountryCode[219]="TZ";
	$arrCountry[220] = "THAILAND"; $arrCountryCode[220]="TH";
	$arrCountry[221] = "TIMOR-LESTE"; $arrCountryCode[221]="TL";
	$arrCountry[222] = "TOGO"; $arrCountryCode[222]="TG";
	$arrCountry[223] = "TOKELAU"; $arrCountryCode[223]="TK";
	$arrCountry[224] = "TONGA"; $arrCountryCode[224]="TO";
	$arrCountry[225] = "TRINIDAD AND TOBAGO"; $arrCountryCode[225]="TT";
	$arrCountry[226] = "TUNISIA"; $arrCountryCode[226]="TN";
	$arrCountry[227] = "TURKEY"; $arrCountryCode[227]="TR";
	$arrCountry[228] = "TURKMENISTAN"; $arrCountryCode[228]="TM";
	$arrCountry[229] = "TURKS AND CAICOS ISLANDS"; $arrCountryCode[229]="TC";
	$arrCountry[230] = "TUVALU"; $arrCountryCode[230]="TV";
	$arrCountry[231] = "UGANDA"; $arrCountryCode[231]="UG";
	$arrCountry[232] = "UKRAINE"; $arrCountryCode[232]="UA";
	$arrCountry[233] = "UNITED ARAB EMIRATES"; $arrCountryCode[233]="AE";
	$arrCountry[234] = "UNITED KINGDOM"; $arrCountryCode[234]="GB";
	$arrCountry[235] = "UNITED STATES"; $arrCountryCode[235]="US";
	$arrCountry[236] = "UNITED STATES MINOR OUTLYING ISLANDS"; $arrCountryCode[236]="UM";
	$arrCountry[237] = "URUGUAY"; $arrCountryCode[237]="UY";
	$arrCountry[238] = "UZBEKISTAN"; $arrCountryCode[238]="UZ";
	$arrCountry[239] = "VANUATU"; $arrCountryCode[239]="VU";
	$arrCountry[240] = "VENEZUELA, BOLIVARIAN REPUBLIC OF"; $arrCountryCode[240]="VE";
	$arrCountry[241] = "VIET NAM"; $arrCountryCode[241]="VN";
	$arrCountry[242] = "VIRGIN ISLANDS, BRITISH"; $arrCountryCode[242]="VG";
	$arrCountry[243] = "VIRGIN ISLANDS, U.S."; $arrCountryCode[243]="VI";
	$arrCountry[244] = "WALLIS AND FUTUNA"; $arrCountryCode[244]="WF";
	$arrCountry[245] = "WESTERN SAHARA"; $arrCountryCode[245]="EH";
	$arrCountry[246] = "YEMEN"; $arrCountryCode[246]="YE";
	$arrCountry[247] = "ZAMBIA"; $arrCountryCode[247]="ZM";
	$arrCountry[248] = "ZIMBABWE"; $arrCountryCode[248]="ZW";
	$ccount = 0;
	foreach($arrCountryCode as $countryCode)
	{
		$arrCountryList[$ccount]  = array(
												"countryCode" => $arrCountryCode[$ccount],
												"country_name"	=> $arrCountry[$ccount]
											);
		$ccount++;
	}
	return $arrCountryList;
}
function getTimes($svalue = "")
{
 
	$string = '&#60;option '.($svalue == '06:00'?'"selected"':'').'value="06:00">06:00 AM&#60;/option>
&#60;option '.($svalue == '06:30'?'"selected"':'').' value="06:30">06:30 AM&#60;/option>
&#60;option '.($svalue == "07:00"?'"selected"':'').' value="07:00">07:00 AM&#60;/option>
&#60;option '.($svalue == "07:30"?'"selected"':'').' value="07:30">07:30 AM&#60;/option>
&#60;option '.($svalue == "08:00"?'"selected"':'').' value="08:00">08:00 AM&#60;/option>
&#60;option '.($svalue == "08:30"?'"selected"':'').' value="08:30">08:30 AM&#60;/option>
&#60;option '.($svalue == "09:00"?'"selected"':'').' value="09:00">09:00 AM&#60;/option>
&#60;option '.($svalue == "09:30"?'"selected"':'').' value="09:30">09:30 AM&#60;/option>
&#60;option '.($svalue == "10:00"?'"selected"':'').' value="10:00">10:00 AM&#60;/option>
&#60;option '.($svalue == "10:30"?'"selected"':'').' value="10:30">10:30 AM&#60;/option>
&#60;option '.($svalue == "11:00"?'"selected"':'').' value="11:00">11:00 AM&#60;/option>
&#60;option '.($svalue == "11:30"?'"selected"':'').' value="11:30">11:30 AM&#60;/option>
&#60;option '.($svalue == "12:00"?'"selected"':'').' value="12:00">12:00 AM&#60;/option>
&#60;option '.($svalue == "12:30"?'"selected"':'').' value="12:30">12:30 PM&#60;/option>
&#60;option '.($svalue == "13:00"?'"selected"':'').' value="13:00">01:00 PM&#60;/option>
&#60;option '.($svalue == "13:30"?'"selected"':'').' value="13:30">01:30 PM&#60;/option>
&#60;option '.($svalue == "14:00"?'"selected"':'').' value="14:00">02:00 PM&#60;/option>
&#60;option '.($svalue == "14:30"?'"selected"':'').' value="14:30">02:30 PM&#60;/option>
&#60;option '.($svalue == "15:00"?'"selected"':'').' value="15:00">03:00 PM&#60;/option>
&#60;option '.($svalue == "15:30"?'"selected"':'').' value="15:30">03:30 PM&#60;/option>
&#60;option '.($svalue == "16:00"?'"selected"':'').' value="16:00">04:00 PM&#60;/option>
&#60;option '.($svalue == "16:30"?'"selected"':'').' value="16:30">04:30 PM&#60;/option>
&#60;option '.($svalue == "17:00"?'"selected"':'').' value="17:00">05:00 PM&#60;/option>
&#60;option '.($svalue == "17:30"?'"selected"':'').' value="17:30">05:30 PM&#60;/option>
&#60;option '.($svalue == "18:00"?'"selected"':'').' value="18:00">06:00 PM&#60;/option>
&#60;option '.($svalue == "18:30"?'"selected"':'').' value="18:30">06:30 PM&#60;/option>
&#60;option '.($svalue == "19:00"?'"selected"':'').' value="19:00">07:00 PM&#60;/option>
&#60;option '.($svalue == "19:30"?'"selected"':'').' value="19:30">07:30 PM&#60;/option>
&#60;option '.($svalue == "20:00"?'"selected"':'').' value="20:00">08:00 PM&#60;/option>
&#60;option '.($svalue == "20:30"?'"selected"':'').' value="20:30">08:30 PM&#60;/option>
';
return $string;
}

function passThroughJS($message = "")
{
	if($message == "") return "";
	/*$message = str_replace(" <br />", "", nl2br(FilterToDbString($message)));
	$message = str_replace("\"", "`", $message);
	$message = preg_replace("/'/", '', $message); */
	$message = rawurlencode($message);
	return $message;
}
#Convert the database date format YYYY-MM-DDD to DD-MMM-YYYY

function DBDateTomyDate($datestr){

	//$arrtmp = split('[/-]', $datestr);

	$arrtmp = preg_split('/[\/-]/', $datestr);

	$retval = "";

	if(count($arrtmp) == 3){ #Check whether the string can be split into 3 parts

		list($year,$month,$day) = $arrtmp;

		$year = intval($year);

		$month = intval($month);

		$day = intval($day);

		$arrMonth = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov","Dec");

		if(checkdate($month, $day, $year)) {

			$day = str_pad($day, 2, '0',STR_PAD_LEFT);

			$month = $arrMonth[$month];

			$retval = "$day-$month-$year";

		}

		return 	$retval;

	}

}

?>
