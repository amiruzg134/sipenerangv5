<?php
$logFile = __DIR__ . '/payment_gateway.log';
$code = isset($_GET['code']) ? $_GET['code'] : null;
$readTime = date('Y-m-d H:i:s');

$accessKey = isset($_SERVER['HTTP_ACCESS_KEY']) ? $_SERVER['HTTP_ACCESS_KEY'] : null;
$validKey = 'Tiketpendakianxtahura@s0s5-api&logkey<*%&#%^>';

if ($accessKey !== $validKey) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'read_time' => $readTime,
        'message' => 'Access Denied. Invalid access-key.'
    ]);
    exit;
}

if (!file_exists($logFile)) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'read_time' => $readTime,
        'message' => 'File log tidak ditemukan.'
    ]);
    exit;
}

$logLines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$logs = [];

foreach ($logLines as $line) {
    $json = json_decode($line, true);
    if ($json) {
        if ($code) {
            if (isset($json['data']['code']) && $json['data']['code'] === $code) {
                $logs[] = $json;
            }
        } else {
            $logs[] = $json;
        }
    }
}

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'read_time' => $readTime,
    'code' => $code ?? 'ALL',
    'log_count' => count($logs),
    'log' => $logs
]);