<?php

namespace PHPVerifyEmail;


interface LogInterface
{
    public function addToLog( $message );

    public function getLog();
}