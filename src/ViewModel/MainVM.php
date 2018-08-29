<?php

namespace DsWeb\ViewModel;

class MainVM extends AbstractVM
{
    public function __construct(string $siteName)
    {
        $this->siteName = $siteName;

        $this->setView('main');
    }
}