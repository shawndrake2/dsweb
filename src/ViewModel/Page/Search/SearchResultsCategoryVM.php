<?php

namespace DsWeb\ViewModel\Page\Search;

use DsWeb\Data\SearchData;
use DsWeb\ViewModel\AbstractVM;
use DsWeb\ViewModel\Common\TableVM;

class SearchResultsCategoryVM extends AbstractVM
{
    private $tableData;

    public function __construct($tableName, $data)
    {
        $this->tableName = $tableName;
        $this->resultsCount = count($data);

        // Columns for this category
        $columns = $this->getColumns($tableName);

        // Get buttons
        $buttons = $this->getButtonData($tableName);

        $this->tableVM = new TableVM($columns, $data, $buttons, $tableName);

        $this->setView('page/search/search-results-category');
    }

    private function getButtonData ($table) {
        $table = $this->getTable($table);
        return $table['buttons'] ?? null;
    }

    private function getColumns ($table) {
        $table = $this->getTable($table);
        $columns = $table['fields'];
        return searchCleanColumns($columns);
    }

    private function getTable($table) {
        if (!$this->tableData) {
            $this->tableData = $this->getTableSearchData();
        }
        return $this->tableData[$table] ?? false;
    }

    private function getTableSearchData ()
    {
        return SearchData::TABLE_DATA;
    }
}