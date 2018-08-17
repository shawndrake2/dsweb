<?php

namespace DsWeb\ViewModel\Page\Component;

use DsWeb\ViewModel\AbstractVM;

class HeaderVM extends AbstractVM
{
    public function __construct(string $siteName)
    {
        $this->siteName = $siteName;

        $this->setView('page/component/header');
    }
}
