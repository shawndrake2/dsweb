<?php

namespace DsWeb\Helper;

use DsWeb\Controller\AuctionHouseController;
use DsWeb\Controller\AuthController;
use DsWeb\Controller\CharacterController;
use DsWeb\Controller\MobController;
use DsWeb\Controller\SearchController;
use DsWeb\Controller\ServerController;
use RapidRoute\RouteCollection;
use RapidRoute\Router;

class RouteHelper
{
    public function getApplicationRouter(string $rootDir) : Router
    {
        return new Router(
            "${rootDir}/router/router.php",
            function (RouteCollection $routes) {

                // GET routes
                $routes->get(
                    '/data/auction-house',
                    ['handler' => [AuctionHouseController::class, 'getListings']]
                );

                $routes->get(
                    '/data/character/{id}',
                    ['handler' => [CharacterController::class, 'getCharacterInfo']]
                );

                $routes->get(
                    '/data/mobs/notorious',
                    ['handler' => [MobController::class, 'getActiveNotoriousMonsters']]
                );

                $routes->get(
                    '/data/search',
                    ['handler' => [SearchController::class, 'getSearchResults']]
                );

                $routes->get(
                    '/data/server',
                    ['handler' => [ServerController::class, 'getServerConfig']]
                );

                // POST routes
                // @TODO Add GET route for testing temporarily
                $routes->get(
                    '/auth/login',
                    ['handler' => [AuthController::class, 'login']]
                );
                $routes->post(
                    '/auth/login',
                    ['handler' => [AuthController::class, 'login']]
                );
            }
        );
    }
}