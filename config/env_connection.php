<?php
function loadEnvConnection($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception(".env file not found at $filePath");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//    var_dump($lines); // Debug: Periksa apakah file terbaca

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");

            putenv("$key=$value");
            $_ENV[$key] = $value;

            // Debug: Periksa key dan value
//            var_dump($key, $value);
        }
    }

    return true;
}
loadEnvConnection(__DIR__ . '/../.env');