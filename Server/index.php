<?php

/**
 * @author Xatziemmanouil Manolis
 * @date July 2014
 *
 * Server Side: Start Service
 */

include "currenciesWebService.php";

$oCurrencyService = new CurrenciesWebService();
$oCurrencyService->registerCurrenciesCalculatorService();

// EOF
