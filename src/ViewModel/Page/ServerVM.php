<?php

namespace DsWeb\ViewModel\Page;

use DsWeb\Config;
use DsWeb\ViewModel\AbstractVM;

class ServerVM extends AbstractVM
{
    public function __construct()
    {
        $configObj = Config::getInstance();
        $this->serverConfig = $configObj->getServerConfig();

        $this->setView('page/server');
    }
}