<?php
//header("Content-Security-Policy: default-src 'self'; script-src 'self' https://apis.google.com https://cdnjs.cloudflare.com style-src 'self' https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css");
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer-when-downgrade");
?>
