<?php

namespace DsWeb\Controller;

use DsWeb\Config;

abstract class AbstractController
{
    protected function getQueryValue($name, $default = '')
    {
        $value = $_GET[$name] ?? $default;
        return trim($value);
    }

    protected function getConfig()
    {
        return Config::getInstance();
    }

    protected function outputData(array $data)
    {
        echo json_encode($data);
    }
}