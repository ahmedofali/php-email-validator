PHP Verify Email
================
Is a php library for validating Emails and make sure the email is valid This library Inspired from 
hbattat/verifyEmail.

How to Use it:
================
```PHP

require "vendor/autoload.php";  

use PHPVerifyEmail\PHPVerifyEmail;  

$email = 'dev.ahmed.abbass@gmail.com';
$verify_email = 'ali338888@gmail.com';
$port = 25;
$verification = PHPVerifyEmail::verify( $email, $verify_email, $port );  

---------------------
// print log
---------------------
print_r( $verification->getLog() );

---------------------
// print Result
---------------------
print_r( $verification->getResult() );
```