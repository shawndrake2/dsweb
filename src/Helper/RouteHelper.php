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

//                // @TODO Update menu to use this controller
//                // Shouldn't be used as of now
//                $routes->get(
//                    '/data/menu/{userId}',
//                    ['handler' => [MenuDataController::class, 'getMenuData']]
//                );
//
//                $routes->get(
//                    '/data/programs',
//                    ['handler' => [ProgramDataController::class, 'getPrograms']]
//                );
//
//                $routes->get(
//                    '/data/program/info',
//                    ['handler' => [ProgramDataController::class, 'getProgramInfo']]
//                );
//
//                $routes->get(
//                    '/data/task/color_rules',
//                    ['handler' => [TaskDataController::class, 'getColorRules']]
//                );
//
//                $routes->get(
//                    '/data/task/fields',
//                    ['handler' => [TaskDataController::class, 'getTaskFields']]
//                );
//
//                $routes->get(
//                    '/data/task/status_codes',
//                    ['handler' => [TaskDataController::class, 'getStatusCodes']]
//                );
//
//                $routes->get(
//                    '/data/timestamps',
//                    ['handler' => [CommonDataController::class, 'getTimeStamps']]
//                );
//
//                $routes->get(
//                    '/login',
//                    ['handler' => [AuthController::class, 'login']]
//                );
//
//                $routes->get(
//                    '/logout',
//                    ['handler' => [AuthController::class, 'logout']]
//                );
//
//                $routes->get(
//                    '/permissions/task/{operation}/{userId}/{programId}',
//                    ['handler' => [PermissionsController::class, 'hasTaskPermission']]
//                );
//
//                // @TODO Update project page to use this controller
//                // Shouldn't be used as of now
//                $routes->get(
//                    '/projects/{projectId}',
//                    ['handler' => [ProjectsController::class, 'getProjectById']]
//                );
//
//                $routes->get(
//                    '/requestaccount',
//                    ['handler' => [AuthController::class, 'requestAccount']]
//                );
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