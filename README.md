PHP Verify Email 
================
[![Build Status](https://travis-ci.org/ahmedofali/php-email-validator.svg?branch=master)](https://travis-ci.org/ahmedofali/php-email-validator) [![Coverage Status](https://coveralls.io/repos/github/ahmedofali/php-email-validator/badge.svg)](https://coveralls.io/github/ahmedofali/php-email-validator)

Is a php library for validating Emails and make sure the email is valid This library Inspired from 
hbattat/verifyEmail.

Installation:
================
```
composer require ahmedofali/php-email-validator
```

How to Use it:
================
```PHP

require "vendor/autoload.php";  

use PHPVerifyEmail\PHPVerifyEmail;  

$email = 'dev.ahmed.abbass@gmail.com';
$verify_email = 'mohamedattya@gmail.com';
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

Test Cases:
============
From Terminal write: 
```
composer test
```
