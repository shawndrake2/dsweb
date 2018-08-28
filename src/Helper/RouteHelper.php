<?php

namespace DsWeb\Helper;

//use MPM\Controller\Api\CommonDataController;
//use MPM\Controller\Api\MenuDataController;
//use MPM\Controller\Api\PermissionsController;
//use MPM\Controller\Api\ProgramDataController;
//use MPM\Controller\Api\TaskDataController;
//use MPM\Controller\Api\UserDataController;
//use MPM\Controller\AuthController;
//use MPM\Controller\ProjectsController;
use DsWeb\Controller\AuctionHouseController;
use DsWeb\Controller\ServerController;
use RapidRoute\RouteCollection;
use RapidRoute\Router;

class RouteHelper
{
    // Conditions to check for in redirect logic
    const DATA_PARAMS = [
        'module' => 'App',
        'action' => 'LocalStorage'
    ];

    // Mapping for implemented legacy endpoints
    const VALID_DATA_ENDPOINTS = [
//        'getProgramInfo' => 'program/info',
    ];

    public function getApplicationRouter(string $rootDir) : Router
    {
        return new Router(
            "${rootDir}/router/router.php",
            function (RouteCollection $routes) {

                $routes->get(
                    '/data/auction-house',
                    ['handler' => [AuctionHouseController::class, 'getListings']]
                );

                $routes->get(
                    '/data/server',
                    ['handler' => [ServerController::class, 'getServerConfig']]
                );

//
//                // @TODO This route still needs proper implementation
//                $routes->post(
//                    '/requestaccount',
//                    ['handler' => [AuthController::class, 'requestAccount']]
//                );
            }
        );
    }
}