<?php
   // Generate a new private (and public) key pair
   $privkey = openssl_pkey_new(array(
      "digest_alg"=>'md5',
      "private_key_bits" => 2048,
      "private_key_type" => OPENSSL_KEYTYPE_RSA,
   ));
   $key_details = openssl_pkey_get_details($privkey);
   print_r($key_details);
?>