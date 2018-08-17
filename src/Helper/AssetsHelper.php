<?php

namespace DsWeb\Helper;

use DsWeb\Config;
use DsWeb\ViewModel\Common\CssLinkViewModel;
use DsWeb\ViewModel\Common\JsLinkViewModel;

class AssetsHelper
{
    const REMOTE = 'remote';
    const LOCAL = 'local';

    private $assets = [];
    private $css;
    private $js;

    public function __construct(Config $config)
    {
        $assets = $config->getAssetsConfig();
        $this->css = (array) $assets->css;
        $this->js = (array) $assets->js;
    }

    public function getAllAssets()
    {
        $localCss = $this->getLocalCss();
        $remoteCss = $this->getRemoteCss();
        $localJs = $this->getLocalJs();
        $remoteJs = $this->getRemoteJs();

        $this->assets = array_merge(
            [],
            $this->getCssLinks($localCss, true), // Local
            $this->getCssLinks($remoteCss, false), // Remote
            $this->getJsLinks($remoteJs, false), // Remote
            $this->getJsLinks($localJs, true) // Local
        );
        return $this->assets;
    }

    private function getCssLinks(array $links, bool $local = true)
    {
        $cssLinks = [];
        foreach ($links as $css) {
            $cssLinks[] = new CssLinkViewModel($css, $local);
        }
        return $cssLinks;
    }

    private function getLocalCss () : ?array
    {
        return $this->getCssAssets(self::LOCAL);
    }

    private function getRemoteCss () : ?array
    {
        return $this->getCssAssets(self::REMOTE);
    }

    private function getCssAssets($hosted = self::LOCAL) : array
    {
        return $this->css[$hosted] ?? [];
    }

    private function getJsLinks(array $links, bool $local = true)
    {
        $jsLinks = [];
        foreach ($links as $js) {
            $jsLinks[] = new JsLinkViewModel($js, $local);
        }
        return $jsLinks;
    }

    private function getLocalJs () : ?array
    {
        return $this->getJsAssets(self::LOCAL);
    }

    private function getRemoteJs () : ?array
    {
        return $this->getJsAssets(self::REMOTE);
    }

    private function getJsAssets($hosted = self::LOCAL) : ?array
    {
        return $this->js[$hosted] ?? null;
    }
}