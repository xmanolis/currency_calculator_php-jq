<?php

/**
 * @author Manolis Xatziemmanouil <manolis@xman.gr>
 * @date July 2025
 */

include_once __DIR__ . "/headers.php";
header('Content-Type: application/json; charset=UTF-8');

$remoteUrl = 'https://currencyconverter.xman.gr/service/available_currencies.php';

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

echo json_encode([
    'success' => true,
    'data'   => $data
]);

// EOF
