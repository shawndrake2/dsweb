<?php

namespace DsWeb\Controller;

use DsWeb\Data\AuctionHouseData;

class AuctionHouseController extends AbstractController
{
    public function getListings(array $args, array $queryParams = [])
    {
        $ahData = new AuctionHouseData();
        $listings =$ahData->getListings($queryParams);
        $this->outputData($listings);
    }
}