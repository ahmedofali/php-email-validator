<?php namespace PHPVerifyEmail\Tests ;

use PHPVerifyEmail\PHPVerifyEmail as EmailVerifier;

class VerifyEmailMxRecordTest extends \PHPUnit_Framework_TestCase
{
    public function testMxRecordEmailReturnTrue()
    {
        $email = 'dev.ahmed.abbas@gmail.com';
        $verify_email = 'ali338888@gmail.com';
        $port = 25;
        $instance = EmailVerifier::verify( $email, $verify_email, $port );

        $this->assertEquals( true , $instance->getResult() );
    }

    public function testMxRecordEmailReturnFalse()
    {
        $email = 'dev.ahmed.abbassss@gmail.com';
        $verify_email = 'dev.ahmed.abbas@gmail.com';
        $port = 25;
        $instance = EmailVerifier::verify( $email, $verify_email, $port );

        $this->assertEquals( false , $instance->getResult() );
    }
}