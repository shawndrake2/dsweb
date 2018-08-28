<?php

namespace DsWeb\Controller;

use DsWeb\Data\AuctionHouseData;

class AuctionHouseController
{
    public function getListings()
    {
        $ahData = new AuctionHouseData();
        $listings =$ahData->getListings();
        $this->outputData($listings);
    }

    private function outputData(array $data)
    {
        echo json_encode($data);
    }
}