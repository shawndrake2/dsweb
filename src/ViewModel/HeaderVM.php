<?php

namespace DsWeb\ViewModel;

class HeaderVM extends AbstractVM
{
    public function __construct(string $siteName)
    {
        $this->siteName = $siteName;

        $this->setView('header');
    }
}
