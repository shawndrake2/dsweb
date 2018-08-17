<?php

namespace DsWeb\Traits;

use DsWeb\Config;

trait DbTrait
{
    private $db;

    public function getDb()
    {
        if (!$this->db) {
            $config = Config::getInstance();
            $dbConfig = $config->getDbConfig();
            $this->db = new \mysqli(
                $dbConfig->host,
                $dbConfig->username,
                $dbConfig->password,
                $dbConfig->dbname
            );
        }
        return $this->db;
    }
}