<?php

namespace DsWeb\ViewModel\Common;

use DsWeb\ViewModel\AbstractVM;

class ErrorMessageVM extends AbstractVM
{
    public function __construct(string $message)
    {
        $this->message = $message;

        $this->setView('common/error-message');
    }
}