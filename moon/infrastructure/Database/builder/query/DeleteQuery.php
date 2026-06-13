<?php

namespace Moon\infrastructure\Database\builder\query;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\builder\packers\DeletePacker;

class DeleteQuery {

    private Database $db;
    private string $table;
    private DeletePacker $deletePacker;

    public function __construct(Database $db, string $table) {
        $this->table = $table;
        $this->db = $db;
        $this->deletePacker = new DeletePacker($table);
    }

    public function where(string $operand, string $value, string $operator = '=') {
        $this->deletePacker->setWhere($operand, $operator, $value);
        return $this;
    }

    public function save() {
        // $this->db->query($this->insertPacker->pack());
        return $this->deletePacker->pack();
    }
}