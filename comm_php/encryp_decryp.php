<?php
// function encryptData($data, $key, $iv) {
//     $cipher = "AES-256-CBC";
//     $encryptedData = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
//     $encryptedData = base64_encode($encryptedData);
//     return $encryptedData;
// }

// function decryptData($encryptedData, $key, $iv) {
//     $cipher = "AES-256-CBC";
//     $encryptedData = base64_decode($encryptedData);
//     $decryptedData = openssl_decrypt($encryptedData, $cipher, $key, OPENSSL_RAW_DATA, $iv);
//     return $decryptedData;
// }

// // Example usage
// $data = "Hello, World!";
// $key = "YourSecretKey";
// $iv = hex2bin("b0e7b56bc9c7581a2b241abcbc2b9c19");

// $encrypted = encryptData($data, $key, $iv);
// echo "Encrypted: " . $encrypted . "\n";

// $decrypted = decryptData($encrypted, $key, $iv);
// echo "Decrypted: " . $decrypted . "\n";

function encryptData($data, $key, $iv) {
    $cipher = "AES-256-CBC";
    $encryptedData = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $encryptedData = base64_encode($encryptedData);
    return $encryptedData;
}

function decryptData($encryptedData, $key, $iv) {
    $cipher = "AES-256-CBC";
    $encryptedData = base64_decode($encryptedData);
    $decryptedData = openssl_decrypt($encryptedData, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    return $decryptedData;
}

// Example usage
$data = "Hello, World!";
$key = "YourSecretKey";
$iv = openssl_random_pseudo_bytes(64);

$encrypted = encryptData($data, $key, $iv);
echo "Encrypted: " . $encrypted . "\n";

$decrypted = decryptData($encrypted, $key, $iv);
echo "Decrypted: " . $decrypted . "\n";


?>
