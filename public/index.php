<?php

use DsWeb\Config;
use DsWeb\Helper\RouteHelper;
use DsWeb\ViewModel\MainVM;
use RapidRoute\MatchResult;

require_once '../vendor/autoload.php';

$routeHelper = new RouteHelper();
$router = $routeHelper->getApplicationRouter(__DIR__);

$router->setDevelopmentMode(true);

try {
    // route logic
    $result = $router->match(
        $_SERVER['REQUEST_METHOD'],
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );
    switch ($result->getStatus()) {
        case MatchResult::FOUND:
            list($controller, $method) = $result->getRouteData()['handler'];
            $parameters = $result->getParameters();
            $controller = new $controller();
            $controller->{$method}($parameters);
            break;
        default:
            $siteName = Config::SITE_NAME;
            $mainVm = new MainVM($siteName);

            // print to page
            echo $mainVm;
            break;
    }
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
    var_dump($throwable->getTrace());
}