<?php

namespace DsWeb\Data;

class AuctionHouseData extends AbstractData
{
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
     * possible filters:
     *  status={sold,unsold}
     *  sort={ah_id,ah_date,ah_price,ah_sale,ah_saledate,item_id,item_name}{asc,desc}
     *  page={{PAGE OFFSET}}
     */
    public function getListings(array $queryParams)
    {
        $status = $this->getStatus($queryParams);

        // where setup
        $where = '';
        if ($status !== 'all') {
            $where = 'WHERE ah.sell_date';
            $where = $status === 'sold' ? "${where} != 0" : "${where} = 0";
        }

        // Get sort order
        $sort = $this->getSort($queryParams);
        $pagination = $this->getPagination($queryParams);

        // Setup query
        $query = "SELECT 
            
            ah.id as ah_id,
            ah.stack as ah_stack,
            ah.date as ah_date,
            ah.price as ah_price,
            ah.sale as ah_sale,
            ah.sell_date as ah_saledate,
    
            item.itemid as item_id,
            item.name as item_name,
    
            chars.charid as character_id,
            chars.charname as character_name
    
        FROM auction_house as ah
        LEFT JOIN item_basic as item ON item.itemid = ah.itemid
        LEFT JOIN chars as chars ON chars.charid = ah.seller
        ${where}
        ${sort}
        ${pagination}";

        $result = $this->getDb()->query($query);

        $listings = [];
        while ($record = $result->fetch_assoc()) {
            $listings[] = $record;
        }
        return $listings;
    }

    private function getPagination(array $queryParams)
    {
        $page = $queryParams['page'] ?? 1;
        $offset = ($page - 1) * self::MAX_PER_PAGE;
        return "LIMIT " . implode(",", [$offset, self::MAX_PER_PAGE]);
    }

    private function getStatus(array $queryParams)
    {
        $status = $queryParams['status'] ?? null;
        return in_array($status, self::STATUSES) ? $status : 'all';
    }

    private function getSort(array $queryParams)
    {
        $sortOptions = [];
        $sortOrder = 'ASC';
        $sort = $queryParams['sort'] ?? null;
        $sort = explode(',', $sort);
        foreach ($sort as $sortOption) {
            if (!in_array(strtolower($sortOption), self::VALID_SORT)) {
                $sortOptions[] = $sortOption;
            } else {
                $sortOrder = strtoupper($sortOption);
            }
        }
        if (count($sortOptions) > 0) {
            return "ORDER BY " . implode(',', $sortOptions) . " ${sortOrder}";
        }
        return '';
    }
}