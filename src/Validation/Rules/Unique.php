<?php

namespace Expomark\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use ORM;

class Unique extends AbstractRule
{
    protected $table;
    protected $column;
    protected $id;

    public function __construct($table, $column, $id)
    {
        $this->table = $table;
        $this->column = $column;
        $this->id = $id;
    }

    public function validate($input)
    {
        $query = ORM::for_table($this->table)->where($this->column, trim($input));

        if ($this->id) {
            $query->where_not_equal('id', $this->id);
        }

        $count = $query->count();

        return $count === 0;
    }
}
