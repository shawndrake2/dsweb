<?php

namespace DsWeb\Controller;

class ServerController extends AbstractController
{
    public function getServerConfig()
    {
        $config = $this->getConfig()->getServerConfig();
        ksort($config, SORT_NATURAL | SORT_FLAG_CASE);
        $this->outputData($config);
    }
}