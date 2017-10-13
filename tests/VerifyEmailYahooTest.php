<?php namespace PHPVerifyEmail\Tests ;

use PHPVerifyEmail\PHPVerifyEmail as EmailVerifier;

class VerifyEmailYahooTest extends \PHPUnit_Framework_TestCase
{
    public function testYahooEmailReturnTrue()
    {
        $email = 'emineme32@yahoo.com';
        $verify_email = 'dev.ahmed.abbas@gmail.com';
        $port = 26;
        $instance = EmailVerifier::verify( $email, $verify_email, $port );

        $this->assertEquals( true , $instance->getResult() );
    }

    public function testYahooEmailReturnFalse()
    {
        $email = 'eeemmmmmmmmm@yahoo.com';
        $verify_email = 'dev.ahmed.abbas@gmail.com';
        $port = 26;
        $instance = EmailVerifier::verify( $email, $verify_email, $port );

        $this->assertEquals( false , $instance->getResult() );
    }

}