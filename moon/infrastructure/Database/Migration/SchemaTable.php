<?php

namespace Moon\infrastructure\Database\Migration;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\Migration\packers\SchemaPacker;

class SchemaTable {

    private string $tableName;
    public array $columns;
    private SchemaPacker $packer;
    private Database $db;

    public function __construct(Database $db, string $tableName, array $columns = [])
    {
        $this->tableName = $tableName;
        $this->packer = new SchemaPacker($tableName);
        $this->columns = $columns;
        $this->db = $db;
    }
    
    private function column(string $name, SchemaTypes $type): bool {
        $column = [
            "name" => $name,
            "type" => $type
        ];
        foreach ($this->columns as $key => $value) {
            if($name == $value['name']) {
                $this->columns[$key] = $column;
                return false;
            }
        }
        $this->columns[] = $column;
        return true;
    }

    private function addOrChangeColumn(string $name, SchemaTypes $type) {
        if($this->column($name, $type)) {
            $this->packer->addColumn($name, $type);
        }
        else {
            $this->packer->changeColumn($name, $type);
        }
    }

    public function id() {
        $this->addOrChangeColumn('id', SchemaTypes::Id);
    }

    public function string(string $name) {
        $this->addOrChangeColumn($name, SchemaTypes::VarChar);
    }

    public function int(string $name) {
        $this->addOrChangeColumn($name, SchemaTypes::Int);
    }

    public function create() {
        $query = $this->packer->pack();
        $this->db->query($query);
    }

}