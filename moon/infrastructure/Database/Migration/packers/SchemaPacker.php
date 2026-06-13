<?php

namespace Moon\infrastructure\Database\Migration\packers;

use Moon\infrastructure\Database\builder\packers\PackerInterface;
use Moon\infrastructure\Database\Migration\SchemaTypes;

class SchemaPacker implements PackerInterface {

    private array $columns = [];
    private string $table;
    
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    private function translateType(SchemaTypes $type) {
        $typeData = '';
        switch($type) {
            case (SchemaTypes::Id): {
                $typeData = 'INT PRIMARY KEY';
                break;
            }
            case (SchemaTypes::Int): {
                $typeData = 'INT';
                break;
            }
            case (SchemaTypes::VarChar): {
                $typeData = 'VARCHAR';
                break;
            }
        }
        return $typeData;
    }

    public function addColumn(string $name, SchemaTypes $type) {
        $this->columns[] = [
            "name" => $name,
            "type" => $this->translateType($type)
        ];
    }

    public function changeColumn(string $name, SchemaTypes $type) {
        $column = [
            "name" => $name,
            "type" => $this->translateType($type)
        ];
        foreach ($this->columns as $key => $value) {
            if($name == $value['name']) {
                $this->columns[$key] = $column;
            }
        }
    }

    public function pack(): string {
        $columns = [];
    
        foreach ($this->columns as $value) {
            $columns[] = $value['name'].' '.$value['type'];
        }
        
        $query = 'CREATE TABLE '.$this->table.' ('.implode(', ', $columns).');';
        
        return $query;
    }
}