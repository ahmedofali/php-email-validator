<?php

namespace PHPVerifyEmail;

use PHPVerifyEmail\LogInterface ;

class EmailVerification
{
    protected $logger;
    protected $email ;
    protected $verifier_email ;
    protected $port ;

    public function newState( LogInterface $logger, $email, $verifier_email, $port )
    {
        return new self( $logger, $email, $verifier_email, $port );
    }

    public function __construct( LogInterface $logger, $email, $verifier_email, $port )
    {
        $this->logger = $logger;
        $this->email = $email;
        $this->verifier_email = $verifier_email;
        $this->port = $port;

        return $this->verify();
    }

    protected function verify()
    {
        // reset log and instantiate new one
        $this->logger->reset();

        $log = sprintf( 'Initialized with Email: %s, Verifier Email: %s, Port: %s', $this->email , $this->verifier_email, $this->port );
        $this->logger->addToLog( $log );
    }

    /**
     * Get Log Messages
     * @return mixed
     */
    public function getLog()
    {
        return $this->logger->getLog();
    }
}