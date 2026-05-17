<?php

namespace Moon\infrastructure\Database\builder\packers;

class UpdatePacker implements PackerInterface {

    private array $params = [];
    private string $table;
    private string $conditionalOperand = '';
    private string $conditionalOperator = '';
    private string $conditionalValue = '';
    private bool $isCond = false;
    
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function setWhere(string $operand, string $operator, string $value) {
        $this->conditionalOperand = $operand;
        $this->conditionalOperator = $operator;
        $this->conditionalValue = $value;
        $this->isCond = true;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    public function pack(): string {
        $query = 'UPDATE '.$this->table.' SET ';
        $rows = '';
        foreach ($this->params as $key => $value) {
            $rows .= "$key = $value, ";
        }
        $rows = substr($rows, 0, -2);
        $query .= $rows;

        if($this->isCond) {
            $query = $query." WHERE ".$this->conditionalOperand." ".$this->conditionalOperator." ".$this->conditionalValue;
        }
        $query = $query.';';
        
        return $query;
    }
}