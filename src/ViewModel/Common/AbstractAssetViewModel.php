<?php

namespace DsWeb\ViewModel\Common;

use DsWeb\Config;
use DsWeb\ViewModel\AbstractVM;

abstract class AbstractAssetViewModel extends AbstractVM
{
    public function __construct(string $link, string $ext, bool $local = true)
    {
        // If the asset file is local, check for minified version
        if ($local) {
            $min = str_ireplace(".${ext}", ".min.${ext}", $link);
            // Minified check
            if (Config::USE_MINIFIED && file_exists($min)) {
                $link = $min;
            }
            // append a timestamp for cache busting
            $version = filemtime($link);
            $link = "${link}?version=${version}";
        }
        $this->asset = $link;
    }
}