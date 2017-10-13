<?php

namespace PHPVerifyEmail;

use PHPVerifyEmail\LogInterface ;

class EmailVerification
{
    protected $logger;
    protected $email ;
    protected $verifier_email ;
    protected $port ;
    protected $result ;

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

        if( $this->isYahoo() ){
            $this->logger->addToLog( 'Figured Out that it\'s a yahoo provider and started verification' );

            $this->setResult( new YahooVerification( $this->logger, $this->email ) );
        }

        return $this ;
    }

    public function setResult( $result ){
        $this->result = $result ;
    }

    public function getResult(){
        return $this->result ;
    }


    /**
     * Get Log Messages
     * @return mixed
     */
    public function getLog()
    {
        return $this->logger->getLog();
    }

    /**
     * Check if provider is yahoo or other provider
     * @return bool
     */
    protected function isYahoo()
    {
        return $this->getDomain( $this->email ) == 'yahoo.com';
    }

    /**
     * Return Email Provider
     * @param $email
     * @return mixed
     */
    protected function getDomain( $email )
    {
        $domain = explode( '@', $email );
        return $domain[1];
    }
}