<?php

use DsWeb\Helper\AuctionHouseBotHelper;

require_once dirname(__DIR__) . "/vendor/autoload.php";

/**
 *
 * I will be running this script every 9-12 minutes in order to simulate
 * a real economy.
 *
 * This script will handle cleanup of old Bot listings so that
 * the server does not have to, cleaning up the bot's delivery box,
 * and stocking anywhere from 0 to 100 random items each time it runs.
 *
 * CRONTAB ENTRY:
 * logfile=/tmp/ahbot.log
 * *\/9 * * * * sleep $(( RANDOM \% 180 )); cd /path/to/dsweb/script && php ahbot.php >> $logfile 2>&1
 *
*/


$bot = new AuctionHouseBotHelper();

echo "TIME STARTED: " . date('F j, Y, g:i a') . PHP_EOL;
$bot->expireOldBotListings();
//    $bot->cleanUpAhDeliveryBox();
$bot->stockRandomAhItems();
$bot->buyRandomAhItems();
echo "====================================" . PHP_EOL . PHP_EOL;
