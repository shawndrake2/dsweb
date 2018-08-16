<?php

use DsWeb\Config;
use DsWeb\Helper\AssetsHelper;

/** @deprecated **/
class Init
{
    /** @var AssetsHelper $assetsHelper */
    private $assetsHelper;

    private $PHPFiles;

    public function __construct(Config $config)
    {
        $this->assetsHelper = new AssetsHelper($config);
    }

    public function head()
    {
        // Print hosted CSS files
        foreach($this->assetsHelper->getRemoteCss() as $css)
        {
            // Print
            echo '<link rel="stylesheet" type="text/css" href="'. $css .'" />';
        }

        // Print CSS Files
        foreach($this->assetsHelper->getLocalCss() as $css)
        {
            // Minified check
            $mincss = str_ireplace('.css', '.min.css', $css);
            if (USE_MINIFIED && file_exists($mincss)) { $css = $mincss; }

            // Version
            $ver = filemtime($css);

            // Print
            echo '<link rel="stylesheet" type="text/css" href="'. $css .'?version='. $ver .'" />';
        }

        // Print Hosted JS files
        foreach($this->assetsHelper->getRemoteJs() as $js)
        {
            // Print
            echo '<script type="text/javascript" src="'. $js .'"></script>';
        }

        // Print JS files
        foreach($this->assetsHelper->getLocalJs() as $js)
        {
            // Minified check
            $minjs = str_ireplace('.js', '.min.js', $js);
            if (USE_MINIFIED && file_exists($minjs)) { $js = $minjs; }

            // Version
            $ver = filemtime($js);

            // Print
            echo '<script type="text/javascript" src="'. $js .'?version='. $ver .'"></script>';
        }
    }

    public function get($Type)
    {
        if ($Type)
        {
            $File = __DIR__ .'/../../'. $this->PHPFiles[$Type];
            if (file_exists($File))
            {
                require_once $File;
            }
            else
            {
                trigger_error('[ $page->get( type ) ] '. $File .' does not exist.', E_USER_ERROR);
            }
        }
        else
        {
            trigger_error('No type passed into $page->get( type ), cannot include file', E_USER_ERROR);
        }
    }
}