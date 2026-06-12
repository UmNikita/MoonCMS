<?php

namespace Moon\infrastructure\Database;

use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\Database\builder\SQLBuilder;
use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Exception\DatabaseException;

class DatabaseFactory {

    private ConfigManager $configManager;
    private Database $db;
    private SQLBuilder $SQLBuilder;

    public function __construct(Database $db, ConfigManager $configManager, SQLBuilder $SQLBuilder)
    {
        $this->configManager = $configManager;
        $this->db = $db;
        $this->SQLBuilder = $SQLBuilder;
    }

    public function create(): Database {
        $this->SQLBuilder->setDatabase($this->db);
        $dbConf = $this->configManager->get('db');
        $driver = $dbConf['driver'];
        $host = $dbConf['host'];
        $port = $dbConf['port'];
        $dbname = $dbConf['dbname'];
        $user = $dbConf['user'];
        $password = $dbConf['password'];
        $this->db->setDatabaseParams($driver, $host, $port, $dbname, $user, $password);
        return $this->db;
    }
}