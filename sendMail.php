<?php
$to      = 'sanjank97@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: sanjub02732@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?> 