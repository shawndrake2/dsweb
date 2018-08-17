<?php

namespace DsWeb\ViewModel\Page\Component;

use DsWeb\ViewModel\AbstractVM;

class NavVM extends AbstractVM
{
    public function __construct()
    {
        $this->setView('page/component/nav');
    }
}
