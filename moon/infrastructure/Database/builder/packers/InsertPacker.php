<?php

namespace Moon\infrastructure\Database\builder\packers;

class InsertPacker implements PackerInterface {

    private array $params = [];
    private string $table;
    private bool $lastId = false;
    private bool $isMany = false;
    
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function setLastId(bool $lastId = true) {
        $this->lastId = $lastId;
    }

    public function setMany(bool $isMany = true) {
        $this->isMany = $isMany;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    public function pack(): string {
        $query = 'INSERT INTO '.$this->table;
        if($this->isMany) {
            // $keys = [];
            // foreach ($this->params as $value) {
            //     foreach ($value as $key => $val) {
            //         $keys[$key][] = $val;
            //     }
            // }
            // foreach ($keys as $key => $value) {

            // }
        }
        else {
            $keys = array_keys($this->params);
            $columns_str = implode(', ', $keys);
            $values = array_values($this->params);
            $values_str = implode(', ', $values);
            $query = $query.' ('.$columns_str.') VALUES '.'( '.$values_str.' )';
        }
        if($this->lastId) {
            $query = $query.'RETURNING id';
        }
        $query = $query.';';
        
        return $query;
    }
}