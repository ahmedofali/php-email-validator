<?php

namespace PHPVerifyEmail;

use PHPVerifyEmail\LogInterface ;

class EmailVerification
{
    protected $logger;

    public function __construct( LogInterface $logger, $email, $verifier_email, $port )
    {
        $this->logger = $logger;
    }
}