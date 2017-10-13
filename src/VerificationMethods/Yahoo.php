<?php namespace PHPVerifyEmail\VerificationMethods ;

use PHPVerifyEmail\Log\LogInterface;
use PHPVerifyEmail\VerificationMethods\VerificationMethodInterface;

class Yahoo implements VerificationMethodInterface
{
    const YAHOO_SIGNUP_PAGE_URL = 'https://login.yahoo.com/account/create?specId=yidReg&lang=en-US&src=&done=https%3A%2F%2Fwww.yahoo.com&display=login';
    const YAHOO_SIGNUP_AJAX_URL = 'https://login.yahoo.com/account/module/create?validateField=yid';

    protected $logger ;
    protected $email ;
    protected $signup_page_contents ;
    protected $signup_page_headers ;

    public function __construct( LogInterface $logger, $email )
    {
        $this->logger = $logger ;
        $this->email = $email ;
    }

    /**
     * Verify Email Exists or not
     * @return bool
     */
    public function verify()
    {
        $this->logger->addToLog( 'Validating a yahoo email address...' );
        $this->logger->addToLog( 'Getting the sign up page content...' );

        $this->signup_page_contents = $this->getYahooSignUpPage();
        $cookies                    = $this->getCookies();
        $fields                     = $this->getFields();

        $this->logger->addToLog( 'Adding the email to fields...' );

        $fields['yid'] = str_replace( '@yahoo.com', '', strtolower( $this->email ) );

        $this->logger->addToLog( 'Ready to submit the POST request to validate the email.' );

        $response = $this->sendAjaxRequest( $cookies, $fields );
        $this->logger->addToLog( 'Parsing the response...' );
        $response = json_decode( $response, true );

        $response_errors = isset( $response['errors'] ) ? $response['errors'] : [] ;
        $this->logger->addToLog( 'Searching errors for existing username error...' );

        foreach( $response_errors as $err ){
            if( $err['name'] == 'yid' && $err['error'] == 'IDENTIFIER_EXISTS' ){
                $this->logger->addToLog( 'Yahoo say this email already exists' );
                return true;
            }
        }

        return false;
    }

    /**
     * Get Yahoo sign up page
     * @return bool|string
     */
    protected function getYahooSignUpPage()
    {
        return $this->getYahooSignUpPageFileGetContents();

        if ( ! function_exists( 'curl_init' ) )
        {
            return $this->getYahooSignUpPageFileGetContents();
        }

        return $this->getYahooSignUpPageCurl();
    }

    /**
     * @TODO add curl function implementation
     * @return bool
     */
    protected function getYahooSignUpPageCurl()
    {

    }

    /**
     * Get Yahoo Sign up page contents and headers
     */
    protected function getYahooSignUpPageFileGetContents()
    {
        $contents = file_get_contents( self::YAHOO_SIGNUP_PAGE_URL );

        if( $contents === false )
        {
            $this->logger->addToLog( 'Could not read the sign up page.' );
        }
        else
        {
            $this->logger->addToLog( 'Sign up page content stored.' );
            $this->logger->addToLog( 'Getting headers...' );
            $this->signup_page_headers = $http_response_header;
            $this->logger->addToLog( 'Sign up page headers stored.' );
        }
        return $contents ;
    }

    /**
     * Extract Cookies from Headers
     * @return array|bool
     */
    protected function getCookies()
    {
        $this->logger->addToLog( 'Attempting to get the cookies from the sign up page...' );

        if( $this->signup_page_contents !== false )
        {
            $this->logger->addToLog( 'Extracting cookies from headers...' );

            $cookies = array();

            foreach ( $this->signup_page_headers as $hdr) {
                if ( preg_match('/^set-cookie:\s*(.*?;).*?$/', $hdr, $matches ) ) {
                    $cookies[] = $matches[1];
                }
            }

            if( count( $cookies ) > 0 ){
                $this->logger->addToLog( 'Cookies found: '.implode(' ', $cookies ) );
                return $cookies;
            }
            else{
                $this->logger->addToLog( 'Could not find any cookies.' );
            }
        }
        return false;
    }


    /**
     * Get Yahoo Fields
     * @return array
     */
    protected function getFields()
    {
        $dom = new \DOMDocument();
        $fields = array();

        if( @$dom->loadHTML( $this->signup_page_contents ) )
        {
            $this->logger->addToLog( 'Parsing the page for input fields...' );
            $xp = new \DOMXpath( $dom );
            $nodes = $xp->query('//input');

            foreach( $nodes as $node ){
                $fields[ $node->getAttribute( 'name' ) ] = $node->getAttribute( 'value' );
            }

            $this->logger->addToLog( 'Extracted fields.' );
        }
        else{
            $this->logger->addToLog( 'Something is worng with the page HTML.' );
        }
        return $fields;
    }

    /**
     * @param $cookies
     * @param $fields
     * @return bool|string
     */
    protected function sendAjaxRequest( $cookies, $fields )
    {
        $headers = array();
        $headers[] = 'Origin: https://login.yahoo.com';
        $headers[] = 'X-Requested-With: XMLHttpRequest';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36';
        $headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
        $headers[] = 'Accept: */*';
        $headers[] = 'Referer: https://login.yahoo.com/account/create?specId=yidReg&lang=en-US&src=&done=https%3A%2F%2Fwww.yahoo.com&display=login';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: en-US,en;q=0.8,ar;q=0.6';

        $cookies = is_null( $cookies ) || ! array( $cookies ) || empty( $cookies ) ? [] : $cookies ;

        $cookies_str = implode(' ', $cookies );
        $headers[] = 'Cookie: '.$cookies_str;

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => $headers,
                'content' => http_build_query( $fields )
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents( self::YAHOO_SIGNUP_AJAX_URL, false, $context );
        return $result;
    }

}
