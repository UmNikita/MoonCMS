<?php

namespace Moon\infrastructure\Database\builder\query;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\builder\packers\UpdatePacker;

class UpdateQuery {

    private Database $db;
    private string $table;
    private UpdatePacker $updatePacker;

    public function __construct(Database $db, string $table, array $params) {
        $this->table = $table;
        $this->db = $db;
        $this->updatePacker = new UpdatePacker($table);
        $this->updatePacker->setParams($params);
    }

    public function where(string $operand, string $value, string $operator = '=') {
        $this->updatePacker->setWhere($operand, $operator, $value);
        return $this;
    }

    public function save() {
        // $this->db->query($this->insertPacker->pack());
        return $this->updatePacker->pack();
    }
}