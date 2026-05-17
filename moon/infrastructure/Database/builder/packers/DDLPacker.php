<?php

namespace Moon\infrastructure\Database\builder\packers;

class DDLPacker implements PackerInterface {

    private array $params = [];
    private string $table;
    private string $queryType;
    
    public function __construct(string $table, string $queryType)
    {
        $this->table = $table;
        $this->queryType = $queryType;
    }

    public function pack(): string {
        switch($this->queryType) {
            case "drop": {
                $query = 'DROP TABLE '.$this->table;
                break;
            };
            default: {
                return "1";
            }
        }
        $query .= ';';
        return $query;
    }
}