<?php

namespace DsWeb\ViewModel;

class MainVM extends AbstractVM
{
    public function __construct(string $siteName, $siteObj)
    {
        $this->siteName = $siteName;
        $this->htmlHead = new HeaderVM($siteName);
        $this->nav = new NavVM();
        $this->footer = new FooterVM();

        /** @deprecated */
        $this->siteObj = $siteObj;

        $this->setView('main');
    }
}