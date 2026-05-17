<?php

namespace Moon\infrastructure\Database;
use PDO;
use Exception;
use Moon\infrastructure\Exception\DatabaseException;
use PDOException;

class Database {

    private PDO $connection;

    public function setDatabaseParams(string $driver, string $host, string $port, string $dbname, string $user, string $password)
    {
        $dsn = "$driver:host=$host;port=$port;dbname=$dbname;";
        try {
            $this->connection = new PDO($dsn, $user, $password);
        }
        catch (Exception $err) {
            throw new DatabaseException("Ошибка подключения к базе данных.");
        }
    }

    public function query(string $query, array $params = []) {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $err) {
            throw new DatabaseException("Ошибка выполнения запроса: " . $err->getMessage(), 0, $err);
        }
    }

    public function begin(): void
    {
        try {
            $this->connection->beginTransaction();
        } catch (PDOException $e) {
            throw new DatabaseException("Ошибка при начале транзакции: " . $e->getMessage());
        }
    }

    public function commit(): void
    {
        try {
            $this->connection->commit();
        } catch (PDOException $e) {
            throw new DatabaseException("Ошибка при коммите транзакции: " . $e->getMessage());
        }
    }

    public function rollback(): void
    {
        try {
            $this->connection->rollBack();
        } catch (PDOException $e) {
            throw new DatabaseException("Ошибка при откате транзакции: " . $e->getMessage());
        }
    }
}