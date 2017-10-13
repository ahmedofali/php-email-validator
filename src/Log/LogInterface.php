<?php

namespace PHPVerifyEmail\Log;


interface LogInterface
{
    public function addToLog( $message );

    public function getLog();

    public function reset();
}