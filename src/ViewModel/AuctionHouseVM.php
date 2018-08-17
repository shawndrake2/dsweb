<?php

namespace DsWeb\ViewModel;

use DsWeb\ViewModel\Common\ErrorMessageVM;

class AuctionHouseVM extends AbstractVM
{
    public function __construct(array $listings = [])
    {
        $this->errorMessage = new ErrorMessageVM(
            'There is nothing for sale on the Auction House.'
        );

        $this->numListings = count($listings);
        $this->listings = $listings;

        $this->setView('auction-house');
    }
}