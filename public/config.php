<?php

use DsWeb\Config;

//@TODO Get rid of this file by refactoring into separate classes/configs

// Use minified scripts?
define ('USE_MINIFIED', false);

$config = Config::getInstance();

#---------------------------------------------------------------

// Files to include
$file_list =
[
    'php-core' =>
    [
        'modules/func/func.php',
        'modules/func/times.php',
        'modules/pdo/pdo.php',
        'modules/init/init.php',
    ],

    'php-misc' =>
    [
        'header'    => 'modules/pages/header.php',
        'nav'       => 'modules/pages/nav.php',
    ]
];

// Include required php files 
foreach($file_list['php-core'] as $f) {
    require_once __DIR__ .'/'. $f;
}

try {
    // Setup
    $Functions = new Funcs();
    $Times = new Times();
    $db = new Database($config->getDbConfig());
    $siteObj = new Init($config);
} catch (Throwable $throwable) {
    echo($throwable->getMessage());
    var_dump($throwable->getTrace());
}

// Disconnect from DB at end of execution (helps to reduce ajax db connection mess)
register_shutdown_function('database_disconnect');
function database_disconnect() {
    global $db;
    $db->Disconnect();
}
