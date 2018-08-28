<?php

namespace DsWeb\ViewModel;

use DsWeb\Config;
use DsWeb\Helper\AssetsHelper;

class MainVM extends AbstractVM
{
    public function __construct(string $siteName)
    {
        $this->siteName = $siteName;

        $assetsHelper = new AssetsHelper(Config::getInstance());
        $this->assets = $assetsHelper->getAllAssets();

        $this->setView('main');
    }
}