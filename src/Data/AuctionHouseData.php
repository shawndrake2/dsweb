<?php

namespace DsWeb\Data;

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

        $listing = $this->getDb()->query($query);

        if ($listing->num_rows > 0)
        {
            // @TODO Build List VMs
//            // Start AH listing
//            echo '<table class="generic-table" cellspacing="0" border="0" cellpadding="10">';
//
//            // Columns
//            echo '<tr class="generic-table-header">
//                <td width="2%" align="center" style="color:#888;">#</td>
//                <td width="2%" align="center">Icon</td>
//                <td width="25%">Item</td>
//                <td width="2%" align="center">Stack</td>
//                <td width="10%" align="right">Price</td>
//                <td width="15%">List Date</td>
//                <td width="10%" align="right">Sale</td>
//                <td width="15%">Sale Date</td>
//                <td width="10%">Profit</td>
//                <td width="15%">Character</td>
//                <td width="15%" align="center" style="color:#A74436;">Actions</td>
//            </tr>';
//
//            // List items
//            foreach($listing as $item)
//            {
//                // Name
//                $name = ucwords(str_ireplace("_", " ", $item['item_name']));
//
//                // Icon from ffxiah
//                $icon = 'http://static.ffxiah.com/images/icon/'. $item['item_id'] .'.png';
//
//                // Stack
//                $stack = ($item['ah_stack'] == 0) ? '&#215;' : '&#10003;';
//
//                // Listing time
//                $listingTime = (new Times())->stringify($item['ah_date']);
//
//                // Sold stuff
//                $listingPrice = number_format($item['ah_price']);
//                $SoldPrice = number_format($item['ah_sale']);
//                $SoldTime = (new Times())->stringify($item['ah_saledate']);
//                $css = null; $Profit = null; $Actions = [];
//                if ($SoldPrice == '0')
//                {
//                    $SoldPrice = '-';
//                    $SoldTime = '-';
//
//                    // Actions
//                    $Actions[] = '<input type="button" value="Buy" style="padding:5px 8px;" />';
//                }
//                // If sold, change bg color
//                else
//                {
//                    $css = 'background:#FCF5C9;';
//
//                    // Work out profit
//                    $Profit = number_format($item['ah_sale'] - $item['ah_price']);
//                }
//
//                // Row
//                echo '<tr style="'. $css .'">
//                    <td align="center" style="color:#aaa;font-size:14px;">'. $item['ah_id'] .'</td>
//                    <td><img src="'. $icon .'" style="margin:-3px -3px -5px -3px;" /></td>
//                    <td>'. $name .'</td>
//                    <td align="center" class="generic-table-symbol" style="color:#aaa;">'. $stack .'</td>
//                    <td align="right">'. $listingPrice .'</td>
//                    <td>'. $listingTime .'</td>
//                    <td align="right">'. $SoldPrice .'</td>
//                    <td>'. $SoldTime .'</td>
//                    <td>'. $Profit .'</td>
//                    <td>'. $item['character_name'] .'</td>
//                    <td align="center" class="form" style="padding:0px;">'. implode("", $Actions) .'</td>
//                </tr>';
//            }
        }
        return [];
    }
}