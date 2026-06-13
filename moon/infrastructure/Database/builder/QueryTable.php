<?php

namespace Moon\infrastructure\Database\builder;

use Moon\infrastructure\Database\builder\query\DeleteQuery;
use Moon\infrastructure\Database\builder\query\InsertQuery;
use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\builder\query\SelectQuery;
use Moon\infrastructure\Database\builder\query\UpdateQuery;

class QueryTable {

    private Database $db;
    private string $table;

    public function __construct(Database $db, string $table) {
        $this->db = $db;
        $this->table = $table;
    }

    public function select(array $params = []) {
        return new SelectQuery($this->db, $this->table, $params);
    }

    public function insert(array $params = []) {
        return new InsertQuery($this->db, $this->table, $params, false);
    }
    
    public function insertMany(array $params = []) {
        return new InsertQuery($this->db, $this->table, $params, true);
    }

    public function update(array $params = []) {
        return new UpdateQuery($this->db, $this->table, $params);
    }
    
    public function delete() {
        return new DeleteQuery($this->db, $this->table);
    }
}