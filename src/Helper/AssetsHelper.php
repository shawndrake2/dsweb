<?php

namespace DsWeb\Helper;

use DsWeb\Config;

class AssetsHelper
{
    const REMOTE = 'remote';
    const LOCAL = 'local';

    private $css;
    private $js;

    public function __construct(Config $config)
    {
        $assets = $config->getAssetsConfig();
        $this->css = (array) $assets->css;
        $this->js = (array) $assets->js;
    }

    public function getLocalCss () : ?array
    {
        return $this->getCssAssets(self::LOCAL);
    }

    public function getRemoteCss () : ?array
    {
        return $this->getCssAssets(self::REMOTE);
    }

    private function getCssAssets($hosted = self::LOCAL) : ?array
    {
        return $this->css[$hosted] ?? null;
    }

    public function getLocalJs () : ?array
    {
        return $this->getJsAssets(self::LOCAL);
    }

    public function getRemoteJs () : ?array
    {
        return $this->getJsAssets(self::REMOTE);
    }

    private function getJsAssets($hosted = self::LOCAL) : ?array
    {
        return $this->js[$hosted] ?? null;
    }
}