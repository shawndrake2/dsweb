<?php

namespace DsWeb\ViewModel\Common;

use DsWeb\ViewModel\AbstractVM;
use DsWeb\ViewModel\Common\Table\TableHeadingsVM;
use DsWeb\ViewModel\Common\Table\TableRowVM;

class TableVM extends AbstractVM
{
    public function __construct($columns, $data, $buttons, $table)
    {
        $this->headings = new TableHeadingsVM($columns);

        $rows = [];
        foreach($data as $record) {
            // UniqueID
            $uniqueId = $record['id'];
            $buttonData = "${table},${uniqueId}";
            $rows[] = new TableRowVM($columns, $record, $buttons, $buttonData);
        }

        $this->rows = $rows;

        $this->setView('common/table');
    }
}