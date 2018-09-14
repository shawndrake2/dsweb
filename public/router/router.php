<?php

use RapidRoute\RapidRouteException;

return function ($method, $uri) {
    if($uri === '') {
        return [0];
    } elseif ($uri[0] !== '/') {
        throw new RapidRouteException("Cannot match route: non-empty uri must be prefixed with '/', '{$uri}' given");
    }

    $segments = explode('/', substr($uri, 1));

    switch (count($segments)) {
        case 2:
            list($s0, $s1) = $segments;
            if ($s0 === 'data') {
                if ($s1 === 'auction-house') {
                    switch ($method) {
                        case 'GET':
                        case 'HEAD':
                            return [2, ['handler' => [
                                0 => 'DsWeb\\Controller\\AuctionHouseController',
                                1 => 'getListings',
                            ]], []];
                        default:
                            $allowedHttpMethods[] = 'GET';
                            $allowedHttpMethods[] = 'HEAD';
                            break;
                    }
                }
                if ($s1 === 'search') {
                    switch ($method) {
                        case 'GET':
                        case 'HEAD':
                            return [2, ['handler' => [
                                0 => 'DsWeb\\Controller\\SearchController',
                                1 => 'getSearchResults',
                            ]], []];
                        default:
                            $allowedHttpMethods[] = 'GET';
                            $allowedHttpMethods[] = 'HEAD';
                            break;
                    }
                }
                if ($s1 === 'server') {
                    switch ($method) {
                        case 'GET':
                        case 'HEAD':
                            return [2, ['handler' => [
                                0 => 'DsWeb\\Controller\\ServerController',
                                1 => 'getServerConfig',
                            ]], []];
                        default:
                            $allowedHttpMethods[] = 'GET';
                            $allowedHttpMethods[] = 'HEAD';
                            break;
                    }
                }
            }
            if ($s0 === 'auth' && $s1 === 'login') {
                switch ($method) {
                    case 'GET':
                    case 'HEAD':
                        return [2, ['handler' => [
                            0 => 'DsWeb\\Controller\\AuthController',
                            1 => 'login',
                        ]], []];
                    case 'POST':
                        return [2, ['handler' => [
                            0 => 'DsWeb\\Controller\\AuthController',
                            1 => 'login',
                        ]], []];
                    default:
                        $allowedHttpMethods[] = 'GET';
                        $allowedHttpMethods[] = 'HEAD';
                        $allowedHttpMethods[] = 'POST';
                        break;
                }
            }
            return isset($allowedHttpMethods) ? [1, $allowedHttpMethods] : [0];
            break;
        
        case 3:
            list($s0, $s1, $s2) = $segments;
            if ($s0 === 'data') {
                if ($s2 !== '' && $s1 === 'character') {
                    switch ($method) {
                        case 'GET':
                        case 'HEAD':
                            return [2, ['handler' => [
                                0 => 'DsWeb\\Controller\\CharacterController',
                                1 => 'getCharacterInfo',
                            ]], ['id' => $s2]];
                        default:
                            $allowedHttpMethods[] = 'GET';
                            $allowedHttpMethods[] = 'HEAD';
                            break;
                    }
                }
                if ($s1 === 'mobs' && $s2 === 'notorious') {
                    switch ($method) {
                        case 'GET':
                        case 'HEAD':
                            return [2, ['handler' => [
                                0 => 'DsWeb\\Controller\\MobController',
                                1 => 'getActiveNotoriousMonsters',
                            ]], []];
                        default:
                            $allowedHttpMethods[] = 'GET';
                            $allowedHttpMethods[] = 'HEAD';
                            break;
                    }
                }
            }
            return isset($allowedHttpMethods) ? [1, $allowedHttpMethods] : [0];
            break;
        
        default:
            return [0];
    }
};
