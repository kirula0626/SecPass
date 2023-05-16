<?php
//header("Content-Security-Policy: default-src 'self'; script-src 'self' https://apis.google.com https://cdnjs.cloudflare.com style-src '*'" );
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer-when-downgrade");
?>
