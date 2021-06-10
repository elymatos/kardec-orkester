<?php

namespace Orkester\Types;

class MRange
{

    public $page;
    public $offset;
    public $rows;
    public $total;

    public function __construct($page, $rows, $total = 0)
    {
        $this->page = $page ? $page : 1;
        $this->offset = ($this->page - 1) * $rows;
        $this->rows = ($total ? ((($this->offset + $rows) > $total) ? $total - $this->offset : $rows) : $rows);
        $this->total = $total;
    }
}
