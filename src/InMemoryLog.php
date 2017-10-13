<?php

namespace PHPVerifyEmail;

use PHPVerifyEmail\LogInterface as Log ;

class InMemoryLog implements Log
{
    protected $log = array();

    /**
     * @param $message
     * @return void
     */
    public function addToLog( $message )
    {
        $this->log[] = $message ;
    }

    /**
     * Check if log array has messages
     * @return bool
     */
    public function hasLog()
    {
        return ! empty( $this->log );
    }

    /**
     * Get LOG Array
     * @return array
     */
    public function getLog()
    {
        return $this->log;
    }
}