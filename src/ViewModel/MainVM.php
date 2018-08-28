<?php

namespace DsWeb\ViewModel;

use DsWeb\Config;
use DsWeb\Helper\AssetsHelper;
use DsWeb\ViewModel\Page\Component\FooterVM;
use DsWeb\ViewModel\Page\Component\HeaderVM;

class MainVM extends AbstractVM
{
    public function __construct(string $siteName)
    {
        $this->siteName = $siteName;
        $this->header = new HeaderVM($siteName);
        $this->footer = new FooterVM();

        $assetsHelper = new AssetsHelper(Config::getInstance());
        $this->assets = $assetsHelper->getAllAssets();

        // Check if server configs exist and pass on to Vue.js
        $configObj = Config::getInstance();
        $this->serverConfig = $configObj->serverConfigPresent() ?
            json_encode($configObj->getServerConfig()) :
            json_encode([]);

        $this->setView('main');
    }
}