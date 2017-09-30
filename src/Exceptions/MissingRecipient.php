<?php

namespace Gabievi\LaravelSMSOffice\Exceptions;

use Exception;

class MissingRecipient extends Exception
{
    /**
     * MissingRecipient constructor.
     */
    public function __construct()
    {
        parent::__construct('Notification was not sent. Phone number is missing.');
    }
}
