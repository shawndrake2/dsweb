<?php

use DsWeb\Config;
use DsWeb\ViewModel\MainVM;

require_once '../vendor/autoload.php';

// Main config
require_once 'config.php';

$siteName = Config::SITE_NAME;
// siteObj is returned from defunct config.php for now
$mainVm = new MainVM($siteName, $siteObj);

// print to page
echo $mainVm;