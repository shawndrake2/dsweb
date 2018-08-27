<?php

namespace DsWeb\Data;

use DsWeb\Helper\AuctionHouseBotHelper;
use DsWeb\ViewModel\Page\Search\AuctionHouseListingVM;

class AuctionHouseData extends AbstractData
{
    private $filters;

    private $page = 1;
    private $maxPerPage = 50;
    private $showAll = true;
    private $soldOnly = true;

    function __construct($filters = null)
    {
        $this->filters = $filters;
    }

    public function getListings()
    {
        // where setup
        $where = '';
        if (!$this->showAll) {
            $where = 'WHERE ah.sell_date';
            $where = $this->soldOnly ? "${where} != 1" : "${where} = 0";
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

    /** @deprecated  */
    public function getListingsVms()
    {
        $listings = $this->getListings();

        // List items
        foreach($listings as $item)
        {
            $listingVM = new AuctionHouseListingVM($item);
            $allListings[] = $listingVM;
        }
        return $allListings;
    }
}