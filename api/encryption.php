<?php
function encrypt($data) {
    $encryption_key = getenv('ENCRYPTION_KEY'); // Use the key from the environment
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($iv . $encrypted); // Store IV with the encrypted data
}

function decrypt($data) {
    $encryption_key = getenv('ENCRYPTION_KEY'); // Use the same secure key
    $data = base64_decode($data);
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $iv_length);
    $encrypted_data = substr($data, $iv_length);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
?>