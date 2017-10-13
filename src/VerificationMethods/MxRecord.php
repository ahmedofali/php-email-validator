<?php namespace PHPVerifyEmail\VerificationMethods;

use PHPVerifyEmail\Log\LogInterface;

class MxRecord implements namespace\VerificationMethodInterface
{
    protected $logger ;
    protected $email ;
    protected $verify_email ;
    protected $port ;
    protected $domain ;
    protected $mx ;
    protected $connect ;

    public function __construct( LogInterface $logger, $email, $verify_email, $port )
    {
        $this->email = $email;
        $this->logger = $logger ;
        $this->verify_email = $verify_email;
        $this->port = $port ;
        $this->domain = $this->getDomain( $email ) ;
    }

    /**
     * @param $email
     * @return mixed
     */
    protected function getDomain( $email )
    {
        $domain = explode( '@', $email );
        return $domain[1];
    }

    public function verify()
    {
        $this->logger->addToLog( 'Finding MX record...' );
        $this->mx = $this->findMx();

        if( ! $this->mx )
        {
            $this->logger->addToLog( 'No MX record was found.' );
            return false ;
        }
        else {
            $this->logger->addToLog( sprintf( 'Found MX: %s', $this->mx ) );
        }

        $this->logger->addToLog( 'Connecting to the server...' );

        $this->connect_mx();

        if( ! $this->connect )
        {
            $this->logger->addToLog( 'Connection to server failed.' );
            return false;
        }
        else {
            $this->logger->addToLog( 'Connection to server was successful.' );
        }
        $this->logger->addToLog( 'Starting verification...' );

        $out = fgets( $this->connect ) ;

        if( preg_match( '/^220/i', $out ) )
        {
            $this->logger->addToLog( 'Got a 220 response. Sending Hello...' );

            fputs ( $this->connect , sprintf( "HELO %s \r\n", $this->getDomain( $this->verify_email ) ) );

            $out = fgets ( $this->connect );

            fputs ( $this->connect , sprintf( "MAIL FROM: <%s>\r\n", $this->verify_email ) );

            $from = fgets ( $this->connect );

            fputs ( $this->connect , sprintf( "RCPT TO: <%s>\r\n", $this->email ) );

            $to = fgets ( $this->connect );

            fputs ( $this->connect , "QUIT" );

            fclose( $this->connect );

            if( ! preg_match( "/^250/i", $from ) || ! preg_match( "/^250/i", $to ) ){
                return false ;
            }
            else{
                $this->logger->addToLog( 'Found! Email is valid.' );
                return true ;
            }
        }
        return false ;
    }

    /**
     * Remove any additional characters from the domain
     */
    protected function cleanDomain()
    {
        if( "IPv6:" == substr( $this->domain , 0, strlen( 'IPv6:' ) ) )
        {
            $this->domain = substr( $this->domain, strlen("IPv6") + 1 );
        }
    }


    protected function findMx()
    {
        $this->cleanDomain();

        if( filter_var( $this->domain, FILTER_VALIDATE_IP ) )
        {
            $record_a = array() ;

            if( filter_var( $this->domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) )
            {
                $record_a = dns_get_record($this->domain, DNS_A);
            }
            elseif( filter_var( $this->domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) )
            {
                $record_a = dns_get_record($this->domain, DNS_AAAA);
            }

            if( ! empty( $record_a ) )
            {
                return $record_a[0]['ip'];
            }
            return $this->domain;
        }else{
            $mx_hosts = array();
            $mx_weight = array();
            getmxrr( $this->domain, $mx_hosts, $mx_weight );

            if( ! empty( $mx_hosts ) )
            {
                return $mx_hosts[ array_search( min( $mx_weight ), $mx_weight ) ];
            }
        }
    }

    /**
     * Establish mx connection
     * @return int mx connection id
     */
    protected function connect_mx()
    {
        $this->connect = @fsockopen( $this->mx, $this->port );
    }

}