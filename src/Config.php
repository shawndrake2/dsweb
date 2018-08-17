<?php

namespace DsWeb;

class Config
{
    const CONFIG_DIR = 'config';

    const SITE_NAME = 'DsWeb';
    const SITE_URL = 'dsweb.local';

    // Use minified scripts?
    const USE_MINIFIED = false;

    private $assetsConfig;
    private $baseDir;
    private $configDir;
    private $dbConfig;

    private static $_instance = null;

    final private function __construct () {}
    final private function __clone() {}

    final public static function getInstance() : self
    {
        static::$_instance = static::$_instance ?? new static();
        return static::$_instance;
    }

    final public static function tearDown()
    {
        static::$_instance = null;
    }

    public function getBaseDir() : string
    {
        if (!$this->baseDir) {
            $this->baseDir = dirname(__DIR__);
        }
        return $this->baseDir;
    }

    public function getConfigDir() : string
    {
        if (!$this->configDir) {
            $this->configDir = $this->getBaseDir() . '/' . self::CONFIG_DIR;
        }
        return $this->configDir;
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
        $file = "{$this->getConfigDir()}/${name}.json";
        if (!file_exists($file)) {
            if (!$required){
                return null;
            }
            throw new \Exception("Required config file missing for '${name}'.");
        }
        return json_decode(file_get_contents($file));
    }

}