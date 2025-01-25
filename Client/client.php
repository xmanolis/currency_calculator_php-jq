<?php
/*
* Created by Xatziemmanouil Manolis
* July 2014
*
* Client Side:Ask Service
*
*
* I could have ajax connect to web service without any php code, but I have to predict that client code may run
* to different server (That's why I have copied nusoap folder twice.).
* But, the truth is that this app is just a currency converter, it isn't supposed to suffer from any cross domain
* attacks.
* Even if it was, they have nothing more to gain than it is already offering.
*
* If I had done it without any php code, then 2 majors changes will be:
* 1) Add header('Access-Control-Allow-Origin: *'); to Server. (Should I put * or just specifics ips?)
* 2) Ajax dataType changes to jsonp
*/

include "nusoap/nusoap.php"; //The required soap tools to get connected to the Server
include "connect_to_webservice.php"; //The class which is responsible to get connected to the Server


@$action = $_POST['action'];

$connect = new connect_to_webservice();

switch($action) {
    case 'get_available_currencies': echo $connect->getAvailableCurrencies();
    break;
    case 'get_currency_conversion': echo $connect->getCurrencyConversion();
    break;
}

// EOF
