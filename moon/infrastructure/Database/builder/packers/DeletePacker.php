<?php

namespace Moon\infrastructure\Database\builder\packers;

class DeletePacker implements PackerInterface {

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


    public function pack(): string {
        $query = 'DELETE FROM '.$this->table;

        if($this->isCond) {
            $query = $query." WHERE ".$this->conditionalOperand." ".$this->conditionalOperator." ".$this->conditionalValue;
        }
        
        $query = $query.';';
        
        return $query;
    }
}