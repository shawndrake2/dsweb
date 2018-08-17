<?php

namespace DsWeb\Data;

use DsWeb\ViewModel\Common\Table\TableHeadingsVM;
use DsWeb\ViewModel\Common\Table\TableRowVM;

class SearchData extends AbstractData
{
    public function getSearchResults (string $searchString)
    {
        // Results array
        $results = [];
        $searchResultsStart = 0;
        $searchResultsMax = 30;

        // muti-search db query
        $tables =
            [
                // Table => [0] columns, [1] where search, [2] options
                // The unique id should ALWAYS be named id, it is used for unique identification
                'accounts' => [
                    ['id', 'login as name', 'email', 'email2'],
                    ['id', 'login', 'email', 'email2'],
                    ['edit'],
                ],

                'chars' => [
                    ['charid as id', 'charname as name', 'pos_zone as zone_id',  'playtime', 'gmlevel'],
                    ['charid', 'charname'],
                    ['edit']
                ],

                'abilities' => [
                    ['abilityId as id', 'name'],
                    ['abilityId', 'name']
                ],

                'item_weapon' => [
                    ['itemId as id', 'name'],
                    ['itemId', 'name']
                ],

                'item_armor' => [
                    ['itemId as id', 'name'],
                    ['itemId', 'name']
                ],
                'item_basic'=> [
                    ['itemId as id', 'name'],
                    ['itemId', 'name']
                ],

                'mob_pools'=> [
                    ['poolid as id', 'name'],
                    ['poolid', 'name']
                ],

                'spell_list'=> [
                    ['spellid as id', 'name'],
                    ['spellid', 'name']
                ],

                'zone_settings'=> [
                    ['zoneid as id', 'name'],
                    ['zoneid',  'name']
                ],

            ];

        // Search each table
        foreach($tables as $table => $data)
        {
            // Build query
            $query = 'SELECT '. implode(",", $data[0]) .' FROM '. $table .' WHERE ';

            // Build where
            $arr = null;
            foreach($data[1] as $c) {
                $arr[] = $c ." LIKE '%". $searchString ."%'";
            }
            $query .= implode(' OR ', $arr);

            // Limit
            $query .= ' LIMIT '. implode(',', [$searchResultsStart, $searchResultsMax]);

            // Get data from db
            $get = $this->getDb()->query($query);

            // Add to results if there was anything
            if ($get->num_rows > 0) {
                // query
                $results[$table] = $get;
            }
        }

        // Loop through results
        if (!empty($results)) {
            foreach($results as $table => $data) {
                // Heading
                echo '<div class="search-category"><strong>'. count($data) .'</strong> <span style="color:#0057C1;">'. $table .'</span></div>';
                echo '<table class="generic-table" border="0" cellpadding="10" cellspacing="0">';

                // Columns for this category
                $columns = $tables[$table][0];
                $columns = searchCleanColumns($columns);

                $tableHeadings = new TableHeadingsVM($columns);
                echo $tableHeadings;

                // Get buttons
                $buttons = $tables[$table][2] ?? null;

                // Data
                foreach($data as $d) {
                    // UniqueID
                    $uniqueId = $d['id'];
                    $buttonData = "${table},${uniqueId}";
                    $rowVM = new TableRowVM($columns, $d, $buttons, $buttonData);
                    echo $rowVM;
                }
                echo '</table>';
            }
        } else {
            // No results found in any of the tables.
            echo '<div class="error">There were no results for: '. $searchString .'</div>';
        }
//        return $results;
    }
}