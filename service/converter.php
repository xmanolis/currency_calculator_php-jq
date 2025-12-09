<?php

/**
 * @author Manolis Xatziemmanouil <manolis@xman.gr>
 * @date July 2025
 */

use Services\CurrenciesRates\CurrencyRatesService as CurrenciesRates;

require_once __DIR__ . "/services/CurrencyRatesService.php";
include_once __DIR__ . "/headers.php";

header('Content-Type: application/json; charset=UTF-8');

$oCurrencyService = new CurrenciesRates();
echo json_encode($oCurrencyService->calculateCurrencies());

// EOF
