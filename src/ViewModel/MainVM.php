<?php

namespace DsWeb\ViewModel;

class MainVM extends AbstractVM
{
    public function __construct(string $siteName, $siteObj)
    {
        $this->siteName = $siteName;

        /** @deprecated */
        $this->siteObj = $siteObj;

        $this->setView('main');
    }
}