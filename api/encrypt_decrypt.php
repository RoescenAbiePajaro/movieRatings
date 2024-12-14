<?php
function encryptData($data, $key) {
    $cipher = "AES-256-CBC";
    $iv = random_bytes(openssl_cipher_iv_length($cipher));
    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv); // Combine encrypted data and IV
}

function decryptData($data, $key) {
    $cipher = "AES-256-CBC";
    list($encryptedData, $iv) = explode('::', base64_decode($data), 2); // Split data and IV
    return openssl_decrypt($encryptedData, $cipher, $key, 0, $iv);
}