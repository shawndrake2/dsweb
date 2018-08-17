<?php

namespace DsWeb\ViewModel\Common\Table;

use DsWeb\ViewModel\AbstractVM;

class TableHeadingsVM extends AbstractVM
{
    public function __construct(array $columns)
    {
        $this->columns = $columns;

        $this->setView('common/table/table-headings');
    }
}