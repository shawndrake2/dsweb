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
        $output = [
            'status' => 200,
            'data' => $data
        ];

        echo json_encode($output);
    }
}