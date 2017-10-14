PHP Verify Email
================
Is a php library for validating Emails and make sure the email is valid This library Inspired from 
hbattat/verifyEmail.

How to Use it:
================
```PHP
$email = 'dev.ahmed.abbas@gmail.com';
$verify_email = 'ali338888@gmail.com';
$port = 25;
$verification = EmailVerifier::verify( $email, $verify_email, $port );
  
// print log   

print_r( $verification->getLog() );
@return  Array of log messages
  
// get Result
$verification->getResult();
@return boolean

```