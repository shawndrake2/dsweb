<?php

namespace DsWeb\Data;

class AuctionHouseData extends AbstractData
{
    const DEFAULT_FIELDS = [];
    const FIELDS_IGNORE = ['actions'];
    const MAX_PER_PAGE = 50;
    const STATUSES = [
        'sold',
        'unsold'
    ];
    const VALID_SORT = [
        'asc',
        'desc'
    ];

    /**
     * possible parameters:
     *  fields={{COMMA DELIMITED LIST OF FIELDS}}
     *  max_results={{RESULTS LIMIT}}
     *  page={{PAGE OFFSET}}
     *  sort={ah_id,ah_date,ah_price,ah_sale,ah_saledate,item_id,item_name}
     *  sort_order={asc,desc}
     *  status={all,sold,unsold}
     */
    public function getListings(array $queryParams)
    {
        // Get fields list
        $fields = $this->getFieldsSql($queryParams);

        // where setup
        $where = '';
        $status = $this->getStatus($queryParams);
        if ($status !== 'all') {
            $where = 'WHERE ah.sell_date';
            $where = $status === 'sold' ? "${where} != 0" : "${where} = 0";
        }

        // Get sort order
        $sort = $this->getSort($queryParams);

        // Get pagination
        $pagination = $this->getPagination($queryParams);

        // Setup query for listings
        $query = $this->buildQuery($fields, $where, $sort, $pagination);
        $result = $this->getDb()->query($query);
        $listings = [];
        while ($record = $result->fetch_assoc()) {
            $listings[] = $record;
        }
        $data['listings'] = $listings;

        // Setup query for listings
        $fields = 'count(ah.id)';
        $query = $this->buildQuery($fields, $where);
        $result = $this->getDb()->query($query);
        while ($record = $result->fetch_row()) {
            $count = (int) $record[0];
        }
        $data['total'] = $count ?? 0;

        return $data;
    }

    private function buildQuery($fields, $where, $sort = '', $pagination = '') {
        return "
        SELECT ${fields}
        FROM auction_house as ah
        LEFT JOIN item_basic as item ON item.itemid = ah.itemid
        LEFT JOIN chars as chars ON chars.charid = ah.seller
        ${where}
        ${sort}
        ${pagination}";
    }

    private function getFieldsSql(array $queryParams) {
        $fieldList = $queryParams['fields'] ? explode(',', $queryParams['fields']) : self::DEFAULT_FIELDS;
        $sql = [];
        // Need these by default
        $sql[] = "ah.id as ah_id";
        $sql[] = "item.itemid as item_id";
        foreach ($fieldList as $field) {
            switch ($field) {
                case 'itemName':
                    $sql[] = "item.name as item_name";
                    break;
                case 'listDate':
                    $sql[] = "ah.date as ah_date";
                    break;
                case 'price':
                    $sql[] = "ah.price as ah_price";
                    break;
                case 'saleDate':
                    $sql[] = "ah.sell_date as ah_saledate";
                    break;
                case 'salePrice':
                    $sql[] = "ah.sale as ah_sale";
                    break;
                case 'seller':
                    $sql[] = "chars.charname as character_name";
                    break;
                case 'stack':
                    $sql[] = "ah.stack as ah_stack";
                    break;
            }
        }
        $sql = !empty($sql) ? implode(', ', $sql) : '';
        return $sql;
    }

    private function getPagination(array $queryParams)
    {
        $maxResults = $queryParams['max_results'] ?? self::MAX_PER_PAGE;
        $page = $queryParams['page'] ?? 1;
        $offset = ($page - 1) * $maxResults;
        return "LIMIT " . implode(",", [$offset, $maxResults]);
    }

    private function getStatus(array $queryParams)
    {
        $status = $queryParams['status'] ?? null;
        return in_array($status, self::STATUSES) ? $status : 'all';
    }

    private function getSort(array $queryParams)
    {
        $sortOptions = [];
        $sort = $queryParams['sort'] ?? null;
        $sortOrder = $queryParams['sort_order'] ?? null;
        $sortOrder = in_array(strtolower($sortOrder), self::VALID_SORT) ? strtoupper($sortOrder) : 'ASC';
        if ($sort) {
            $sort = explode(',', $sort);
            foreach ($sort as $sortOption) {
                if (!empty($sortOption)) {
                    $sortOptions[] = $sortOption;
                }
            }
        }
        if (count($sortOptions) > 0) {
            return "ORDER BY " . implode(',', $sortOptions) . " ${sortOrder}";
        }
        return '';
    }
}