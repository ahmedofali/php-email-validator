<?php namespace PHPVerifyEmail\Tests ;

use PHPVerifyEmail\PHPVerifyEmail as EmailVerifier;

abstract class AbstractVerifyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowExceptionWhenInvalidEmail()
    {
        $email = 'dev.ahmed.abbas-gmail.com';
        $verify_email = 'dev.ahmed.abbas@gmail.com';
        $port = 26;

        EmailVerifier::verify( $email, $verify_email, $port );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowExceptionWhenInvalidVerifierEmail()
    {
        $email = 'dev.ahmed.abbas@gmail.com';
        $verify_email = 'dev.ahmed.abbas-gmail.com';
        $port = 26;

        EmailVerifier::verify( $email, $verify_email, $port );
    }

}