<?php
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


?>
