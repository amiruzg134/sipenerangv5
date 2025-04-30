<?php
//$accessKey = isset($_SERVER['HTTP_ACCESS_KEY']) ? $_SERVER['HTTP_ACCESS_KEY'] : null;
//$validKey = 'Tiketpendakianxtahura@s0s5-api&logkey<*%&#%^>';
//
//if ($accessKey !== $validKey) {
//    http_response_code(401);
//    header('Content-Type: application/json');
//    echo json_encode([
//        'status' => 'error',
//        'message' => 'Access Denied. Invalid access-key.'
//    ]);
//    exit;
//}

$code = isset($_GET['code']) ? $_GET['code'] : null;

if ($code === null) {
    echo "Code tidak ditemukan";
    exit;
}

$code_decode64 = base64_decode($code);

$logFile = dirname(__DIR__) . '/logs/' . $code_decode64 . '.log';
if (!file_exists($logFile)) {
    echo "Log file tidak ditemukan";
    exit;
}

$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$logEntries = [];

foreach ($lines as $line) {
    $logEntries[] = json_decode($line, true);
}
header('Content-Type: application/json');
echo json_encode($logEntries, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>