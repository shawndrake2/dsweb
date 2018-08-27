<?php

use DsWeb\Data\AuctionHouseData;
use DsWeb\ViewModel\Page\AuctionHouseVM;

require_once '../vendor/autoload.php';

$ahData = new AuctionHouseData();
$listings = $ahData->getListingsVms();
$auctionHouseVM = new AuctionHouseVM($listings);
echo $auctionHouseVM;
