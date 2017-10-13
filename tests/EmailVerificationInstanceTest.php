<?php namespace PHPVerifyEmail\Tests ;

use PHPVerifyEmail\PHPVerifyEmail as EmailVerifier;
use \PHPVerifyEmail\Tests\AbstractVerifyTest;
use \PHPVerifyEmail\EmailVerification ;

class EmailVerificationInstance extends AbstractVerifyTest
{
    public function testReturnInstanceOfEmailVerification()
    {
        $email = 'dev.ahmed.abbas@gmail.com';
        $verify_email = 'dev.ahmed.abbas@gmail.com';
        $port = 26;
        $instance = EmailVerifier::verify( $email, $verify_email, $port );

        $this->assertInstanceOf( EmailVerification::class , $instance );
    }

    public function testLogFilledAfterClassInstantiation()
    {
        $email = 'dev.ahmed.abbas@gmail.com';
        $verify_email = 'dev.ahmed.abbas@gmail.com';
        $port = 26;
        $instance = EmailVerifier::verify( $email, $verify_email, $port );

        $this->assertArrayHasKey( 0, $instance->getLog() );
    }

    public function testIfYahooLogWillIncerement()
    {
        $email = 'checkifyahoo@yahoo.com';
        $verify_email = 'dev.ahmed.abbas@gmail.com';
        $port = 26;
        $instance = EmailVerifier::verify( $email, $verify_email, $port );

        $this->assertArrayHasKey( 1, $instance->getLog() );
    }
}