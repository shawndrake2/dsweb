<?php

namespace DsWeb\ViewModel\Page\Search;

use DsWeb\Helper\TimeHelper;
use DsWeb\ViewModel\AbstractVM;

class AuctionHouseListingVM extends AbstractVM
{
    public function __construct(array $listing)
    {
        $this->name = ucwords(
            str_ireplace("_", " ", $listing['item_name'])
        );

        // Icon from ffxiah
        $itemId = $listing['item_id'];
        $this->icon = "http://static.ffxiah.com/images/icon/${itemId}.png";

        $this->stack = $listing['ah_stack'] === 0 ? '&#215;' : '&#10003;';

        $timeHelper = new TimeHelper();
        $this->listingTime = $timeHelper->getAuctionTimeAsString($listing['ah_date']);

        $this->listingPrice = number_format($listing['ah_price']);

        $this->soldPrice = number_format($listing['ah_sale']);
        $this->soldTime = $timeHelper->getAuctionTimeAsString($listing['ah_saledate']);

        $this->css = null;
        $this->profit = null;
        $actions = [];

        if ($this->soldPrice === '0') {
            $this->soldPrice = '-';
            $this->soldTime = '-';

            // Actions
            $actions[] = '<input type="button" value="Buy" style="padding:5px 8px;" />';
        } else {
            // If sold, change bg color
            $this->css = 'background:#FCF5C9;';

            // Work out profit
            $this->profit = number_format(
                $listing['ah_sale'] - $listing['ah_price']
            );
        }

        $this->actions = $actions;

        $this->setView('page/search/auction-house-listing');
    }
}