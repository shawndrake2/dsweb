<?php

namespace DsWeb\Data;

class SearchData extends AbstractData
{
    const TABLE_DATA =             [
        // Table => [0] columns, [1] where search, [2] options
        // The unique id should ALWAYS be named id, it is used for unique identification
        'accounts' => [
            'fields' => ['id', 'login as name', 'email', 'email2'],
            'where' => ['id', 'login', 'email', 'email2'],
            'buttons' => ['edit'],
        ],

        'chars' => [
            'fields' => ['charid as id', 'charname as name', 'pos_zone as zone_id',  'playtime', 'gmlevel'],
            'where' => ['charid', 'charname'],
            'buttons' => ['edit']
        ],

        'abilities' => [
            'fields' => ['abilityId as id', 'name'],
            'where' => ['abilityId', 'name']
        ],

        'item_weapon' => [
            'fields' => ['itemId as id', 'name'],
            'where' => ['itemId', 'name']
        ],

        'item_armor' => [
            'fields' => ['itemId as id', 'name'],
            'where' => ['itemId', 'name']
        ],

        'item_basic'=> [
            'fields' => ['itemId as id', 'name'],
            'where' => ['itemId', 'name']
        ],

        'mob_pools'=> [
            'fields' => ['poolid as id', 'name'],
            'where' => ['poolid', 'name']
        ],

        'spell_list'=> [
            'fields' => ['spellid as id', 'name'],
            'where' => ['spellid', 'name']
        ],

        'zone_settings'=> [
            'fields' => ['zoneid as id', 'name'],
            'where' => ['zoneid',  'name']
        ]

    ];

    public function getSearchResults (string $searchString, $filters = [], $view = true)
    {
        // Results array
        $results = false;
        $searchResultsStart = 0;
        $searchResultsMax = 30;

        $response = [];

        $categories = $filters['categories'] ?? array_keys(self::TABLE_DATA);

        // Search each table
        foreach(self::TABLE_DATA as $table => $data)
        {
            if (in_array($table, $categories)) {
                // Build query
                $fields = implode(",", $data['fields']);
                $query = "SELECT ${fields} FROM ${table} WHERE ";

                // Build where condition
                $where = [];
                foreach ($data['where'] as $condition) {
                    $where[] = "${condition} LIKE '%${searchString}%'";
                }
                $query .= implode(' OR ', $where);

                // Limit
                $limit = "${searchResultsStart},${searchResultsMax}";
                $query .= " LIMIT ${limit}";

                // Get data from db
                $result = $this->getDb()->query($query);

                // Add to results if there was anything
                if ($result->num_rows > 0) {
                    $results = true;
                    $resultData = $result->fetch_all(MYSQLI_ASSOC);
                    // query
                    $response[$table] = $resultData;
                }
            }
        }

        return $response;
    }
}