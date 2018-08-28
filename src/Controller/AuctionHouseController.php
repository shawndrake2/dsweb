<?php

namespace DsWeb\Controller;

use DsWeb\Data\AuctionHouseData;

class AuctionHouseController extends AbstractController
{
    public function getListings()
    {
        $ahData = new AuctionHouseData();
        $listings =$ahData->getListings();
        $this->outputData($listings);
    }
}