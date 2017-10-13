PHP Verify Email
================
Is a php library for validating Emails and make sure the email is valid This library Inspired from 
hbattat/verifyEmail.

How to Use it:
================
```PHP
$result = PHPVerifyEmail::verify( 'dev.ahmed.abbas@gmail.com' );   
  
// print log   

print_r( $result->getLog() ) ;
  
// get Result
$result->getResult();

```