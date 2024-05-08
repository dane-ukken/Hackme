<?php
$secretKeyFile = __DIR__ . '/secret_key.bin'; 

$key = openssl_random_pseudo_bytes(32);
if ($key === false) {
    echo "Failed to generate the encryption key.\n";
    exit;
}

$result = @file_put_contents($secretKeyFile, $key);
if ($result === false) {
    echo "Failed to store the encryption key.\n";
    exit;
}

$chmodResult = @chmod($secretKeyFile, 0400);
if ($chmodResult === false) {
    echo "Failed to set file permissions.\n";
    exit;
}

echo "Encryption key generated and stored successfully.\n";
?>
