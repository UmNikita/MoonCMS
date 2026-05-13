<?php

namespace Moon\infrastructure\Database;
use PDO;
use Exception;
use Moon\infrastructure\Exception\DatabaseException;

class Database {

    private PDO $connection;

    public function __construct(string $driver, string $host, string $port, string $dbname, string $user, string $password)
    {
        $dsn = "$driver:host=$host;port=$port;dbname=$dbname;";
        try {
            $this->connection = new PDO($dsn, $user, $password);
        }
        catch (Exception $err) {
            throw new DatabaseException("Ошибка подключения к базе данных.");
        }
        
    }
}