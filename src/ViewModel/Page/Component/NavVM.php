<?php

namespace DsWeb\ViewModel\Page\Component;

use DsWeb\Config;
use DsWeb\ViewModel\AbstractVM;

class NavVM extends AbstractVM
{
    public function __construct()
    {
        $configObj = Config::getInstance();
        $this->serverConfigs = $configObj->serverConfigPresent();

        $this->setView('page/component/nav');
    }
}
