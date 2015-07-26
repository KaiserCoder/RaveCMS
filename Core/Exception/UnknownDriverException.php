<?php

namespace Rave\Core\Exception;

class UnknownDriverException extends \Exception
{
    const ERROR_CODE = 2;

    public function __construct($message)
    {
        parent::__construct($message, self::ERROR_CODE);
    }

}