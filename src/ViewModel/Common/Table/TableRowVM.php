<?php

namespace DsWeb\ViewModel\Common\Table;

use DsWeb\ViewModel\AbstractVM;

class TableRowVM extends AbstractVM
{
    public function __construct(array $columns, $data, $buttons, $buttonData)
    {
        if (!empty($buttons)) {
            $this->buttons = $buttons;
            $this->buttonData = $buttonData;
        }

        $fields = [];
        foreach ($columns as $column) {
            // Style for id
            $field['width'] = $column === 'id' ? '80px' : 'auto';

            // Get data
            $field['value'] = $data[$column];

            $fields[] = $field;
        }

        $this->fields = $fields;

        $this->setView('common/table/table-row');
    }
}