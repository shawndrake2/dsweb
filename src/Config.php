<?php

namespace DsWeb;

class Config
{
    const CONFIG_DIR = 'config';

    const SITE_NAME = 'DsWeb';
    const SITE_URL = 'dsweb.local';

    private $assetsConfig;
    private $baseDir;
    private $dbConfig;

    public function getBaseDir() {
        if (!$this->baseDir) {
            $this->baseDir = dirname(__DIR__) . '/' . self::CONFIG_DIR;
        }
        return $this->baseDir;
    }

    /** @throws \Exception */
    public function getAssetsConfig () : \stdClass
    {
        if (!$this->assetsConfig) {
            $this->assetsConfig = $this->fetchConfigFile('assets', true);
        }
        return $this->assetsConfig;
    }

    /** @throws \Exception */
    public function getDbConfig () : \stdClass
    {
        if (!$this->dbConfig) {
            $this->dbConfig = $this->fetchConfigFile('database', true);
        }
        return $this->dbConfig;
    }

    /** @throws \Exception */
    private function fetchConfigFile (string $name, bool $required = false) : ?\stdClass
    {
        $file = "{$this->getBaseDir()}/${name}.json";
        if (!file_exists($file)) {
            if (!$required){
                return null;
            }
            throw new \Exception("Required config file missing for '${name}'.");
        }
        return json_decode(file_get_contents($file));
    }

}