<?php namespace PHPVerifyEmail\VerificationMethods ;

use PHPVerifyEmail\LogInterface;
use PHPVerifyEmail\VerificationMethods\VerificationMethodInterface;

class YahooVerification implements VerificationMethodInterface
{
    const YAHOO_SIGNUP_PAGE_URL = 'https://login.yahoo.com/account/create?specId=yidReg&lang=en-US&src=&done=https%3A%2F%2Fwww.yahoo.com&display=login';
    const YAHOO_SIGNUP_AJAX_URL = 'https://login.yahoo.com/account/module/create?validateField=yid';

    protected $logger ;
    protected $email ;

    public function __construct( LogInterface $logger, $email )
    {
        $this->logger = $logger ;
        $this->email = $email ;

        return $this->verify();
    }


}
