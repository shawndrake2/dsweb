<?php

namespace DsWeb\Controller;

use DsWeb\Config;

abstract class AbstractController
{
    protected function getConfig()
    {
        return Config::getInstance();
    }

    protected function outputData(array $data)
    {
        echo json_encode($data);
    }
}