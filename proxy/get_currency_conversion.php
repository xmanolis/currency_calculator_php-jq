<?php

/**
 * @author Manolis Xatziemmanouil <manolis@xman.gr>
 * @date July 2025
 */

include 'helpers.php';
include_once __DIR__."/headers.php";
header('Content-Type: application/json; charset=UTF-8');

$amount       = $_GET['AMOUNT'] ?? '';
$fromCurrency = $_GET['FROM_CURRENCY'] ?? '';
$toCurrency   = $_GET['TO_CURRENCY'] ?? '';

if (!validateAmount($amount) || !validateCurrency($fromCurrency) || !validateCurrency($toCurrency)) {
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid input format'
    ]);
    exit;
}

$params    = [
    'FROM_CURRENCY' => $fromCurrency,
    'TO_CURRENCY'   => $toCurrency,
    'AMOUNT'       => $amount
];
$remoteUrl = 'https://currencyconverter.xman.gr/service/converter.php?'.http_build_query($params);

$context  = stream_context_create([
    'http' => [
        'method'        => 'GET',
        'header'        => "Accept: application/json\r\n",
        'timeout'       => 3,
        'ignore_errors' => true
    ],
    'ssl'  => [
        'verify_peer'      => true,
        'verify_peer_name' => true,
    ]
]);
$response = file_get_contents($remoteUrl, false, $context);

if ($response === false) {
    echo json_encode([
        'success' => false,
        'error'   => 'Remote service unreachable'
    ]);
    exit;
}

$data = json_decode($response, true);

if (!is_array($data)) {
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid JSON received from remote service'
    ]);
    exit;
}

echo json_encode($data);

// EOF