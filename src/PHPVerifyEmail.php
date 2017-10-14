<?php namespace PHPVerifyEmail;

use PHPVerifyEmail\Log\InMemoryLog ;
use PHPVerifyEmail\EmailVerification ;
use \InvalidArgumentException ;

/*
 * (c) Ahmed Ali <dev.ahmed.abbas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
final class PHPVerifyEmail
{
    /**
     * @param string $email
     * @param string $verifier_email
     * @param int $port
     * @return \PHPVerifyEmail\EmailVerification
     */
    public static function verify( $email, $verifier_email = null, $port = 25 )
    {
        if( self::verifyValidEmail( $email ) &&  self::verifyValidEmail( $verifier_email ) )
        {
            $log = new InMemoryLog();

            return new EmailVerification( $log, $email, $verifier_email, $port );
        }
    }

    /**
     * Verify Email is valid in structure
     * @param $email
     * @return bool
     * @throws \Exception
     */
    protected static function verifyValidEmail( $email )
    {
        if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
            throw new \InvalidArgumentException( sprintf( '%s is not a valid email' , $email ) );
        }
        return true ;
    }
}