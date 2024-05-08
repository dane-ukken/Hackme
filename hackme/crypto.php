<?php
function encryptData($data) {
    $secretKeyFile = __DIR__ . '/secret_key.bin';
    $key = file_get_contents($secretKeyFile);
    if ($key === false) {
        die('Failed to read the encryption key.');
    }
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', base64_decode($key), 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decryptData($data) {
    $secretKeyFile = __DIR__ . '/secret_key.bin';
    $key = file_get_contents($secretKeyFile);
    if ($key === false) {
        die('Failed to read the encryption key.');
    }
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', base64_decode($key), 0, $iv);
}
?>  