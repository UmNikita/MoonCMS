<?php

namespace Moon\infrastructure\Database\Migration;

use Moon\infrastructure\Database\Database;

class Schema {

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function table(string $table) {
        if($this->tableExist($table))
        {
            $columns = $this->setColumnsTable($table);
            return new SchemaTable($this->db, $table, $columns);
        }
        else
            return new SchemaTable($this->db, $table);
        
    }

    private function tableExist(string $table) {
        $sql = "SELECT 1 FROM information_schema.tables WHERE table_schema = 'public' AND table_name = :table";
        $exist = $this->db->query($sql, ['table'=>$table])->fetchColumn();
        return $exist;
    }

    private function setColumnsTable(string $table) {
        $sql = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :table";
        $cols = $this->db->query($sql, ['table'=>$table])->fetchAll();
        $columnsArr = [];
        foreach ($cols as $key => $value) {
            $typeData = SchemaTypes::Id;
            if($value['column_name'] != 'id') {
                $typeData = SchemaTypes::Id;
                switch($value['data_type']) {
                    case ("integer"): {
                        $typeData = SchemaTypes::Int;
                        break;
                    }
                    case ("character varying"): {
                        $typeData = SchemaTypes::VarChar;
                        break;
                    }
                }
            }
            $columnsArr[] = [
                "name" => $value['column_name'],
                "type" => $typeData
            ]; 
        }
        return $columnsArr;
    }

}