<?php

namespace DsWeb\ViewModel;

use DsWeb\Config;
use DsWeb\Helper\AssetsHelper;
use DsWeb\ViewModel\Page\Component\FooterVM;
use DsWeb\ViewModel\Page\Component\HeaderVM;
use DsWeb\ViewModel\Page\Component\NavVM;

class MainVM extends AbstractVM
{
    public function __construct(string $siteName)
    {
        $this->siteName = $siteName;
        $this->header = new HeaderVM($siteName);
        $this->nav = new NavVM();
        $this->footer = new FooterVM();

        $assetsHelper = new AssetsHelper(Config::getInstance());
        $this->assets = $assetsHelper->getAllAssets();

        $this->setView('main');
    }
}