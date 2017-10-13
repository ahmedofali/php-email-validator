PHP Verify Email
================
Is a php library for veriging Emails and make sure the email is valid Basically This library Inspired from 
hbattat/verifyEmail.

How to Use it:
```PHP
$result = PHPVerifyEmail::verify( 'dev.ahmed.abbas@gmail.com' );   
  
// print log   

print_r( $result->log ) ;
  
// get Result
$result->result();

```