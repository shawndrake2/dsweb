<?php

use DsWeb\Data\AuctionHouseData;
use DsWeb\ViewModel\AuctionHouseVM;

require_once '../vendor/autoload.php';

$ahData = new AuctionHouseData();
$listings = $ahData->getListings();
$auctionHouseVM = new AuctionHouseVM($listings);
echo $auctionHouseVM;
