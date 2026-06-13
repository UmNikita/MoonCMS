<?php

namespace Moon\infrastructure\Database\builder\query;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\builder\packers\SelectPacker;

class SelectQuery {

    private Database $db;
    private string $table;
    private SelectPacker $selectPacker;

    public function __construct(Database $db, string $table, array $params) {
        $this->table = $table;
        $this->db = $db;
        $this->selectPacker = new SelectPacker($table);
        $this->selectPacker->setParams($params);
    }

    public function distinct() {
        $this->selectPacker->setDistinct();
        return $this;
    }

    public function limit(int $limit) {
        $this->selectPacker->setLimit($limit);
        return $this;
    }

    public function where(string $operand, string $value, string $operator = '=') {
        $this->selectPacker->setWhere($operand, $operator, $value);
        return $this;
    }

    public function get() {
        // $this->db->query($this->selectPacker->pack());
        return $this->selectPacker->pack();
    }
}