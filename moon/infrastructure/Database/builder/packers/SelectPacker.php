<?php

namespace Moon\infrastructure\Database\builder\packers;

class SelectPacker implements PackerInterface {

    private array $params = [];
    private string $table;
    private bool $distinct = false;
    private int $limit = -1;
    private string $conditionalOperand = '';
    private string $conditionalOperator = '';
    private string $conditionalValue = '';
    private bool $isCond = false;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function setParams(array $params) {
        $this->params = $params;
    }

    public function setDistinct(bool $distinct = true) {
        $this->distinct = $distinct;
    }

    public function setLimit(int $limit) {
        $this->limit = $limit;
    }

    public function setWhere(string $operand, string $operator, string $value) {
        $this->conditionalOperand = $operand;
        $this->conditionalOperator = $operator;
        $this->conditionalValue = $value;
        $this->isCond = true;
    }

    public function pack(): string {
        $query = 'SELECT';
        
        if($this->distinct)
            $query = $query." DISTINCT";

        if(count($this->params) == 0) {
            $query = $query." *";
        }
        else {
            $columns = implode(', ', $this->params);
            $query = $query." {$columns}";
        }

        $query = $query.' FROM '.$this->table;

        if($this->isCond) {
            $query = $query." ".$this->conditionalOperand." ".$this->conditionalOperator." ".$this->conditionalValue;
        }

        if($this->limit != -1)
            $query = $query." LIMIT ".$this->limit;
        
        $query = $query.';';

        return $query;
    }
}