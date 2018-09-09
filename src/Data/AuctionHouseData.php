<?php

namespace DsWeb\Data;

class AuctionHouseData extends AbstractData
{
    const STATUSES = [
        'sold',
        'unsold'
    ];

    private $filters;

    private $page = 1;
    private $maxPerPage = 50;

    function __construct($filters = null)
    {
        $this->filters = $filters;
    }

    /**
     * possible filters:
     *  status={sold,unsold}
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

        // Setup query
        $query = 'SELECT 
            
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
        '. $where .'
        ORDER BY ah.id DESC
        LIMIT '. implode(",", [($this->page-1) * $this->maxPerPage, $this->maxPerPage]);

        $result = $this->getDb()->query($query);

        while ($record = $result->fetch_assoc()) {
            $listings[] = $record;
        }
        return $listings;
    }

    private function getStatus(array $queryParams)
    {
        $status = $queryParams['status'] ?? null;
        return in_array($status, self::STATUSES) ? $status : 'all';
    }
}