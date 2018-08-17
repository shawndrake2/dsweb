<?php

use DsWeb\Config;
use DsWeb\ViewModel\MainVM;

require_once '../vendor/autoload.php';

$siteName = Config::SITE_NAME;
$mainVm = new MainVM($siteName);

// print to page
echo $mainVm;