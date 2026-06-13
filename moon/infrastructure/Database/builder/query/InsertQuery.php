<?php

namespace Moon\infrastructure\Database\builder\query;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\builder\packers\InsertPacker;

class InsertQuery {

    private Database $db;
    private string $table;
    private InsertPacker $insertPacker;

    public function __construct(Database $db, string $table, array $params, bool $isMany) {
        $this->table = $table;
        $this->db = $db;
        $this->insertPacker = new InsertPacker($table);
        $this->insertPacker->setParams($params);
        $this->insertPacker->setMany($isMany);
    }

    public function lastId() {
        $this->insertPacker->setLastId();
        return $this;
    }

    public function save() {
        // $this->db->query($this->insertPacker->pack());
        return $this->insertPacker->pack();
    }
}