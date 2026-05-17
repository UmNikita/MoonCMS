<?php

namespace Moon\infrastructure\Database\builder;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\builder\QueryTable;

class SQLBuilder {

    private Database $db;

    public function setDatabase(Database $db) {
        $this->db = $db;
    }

    public function table(string $tableName): QueryTable {
        return new QueryTable($this->db, $tableName);
    }
}