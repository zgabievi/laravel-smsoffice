<?php

namespace Gabievi\LaravelSMSOffice\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * InvalidConfiguration constructor.
     */
    public function __construct()
    {
        parent::__construct('`smsoffice` configuration is not defined in `config.services`.');
    }
}
