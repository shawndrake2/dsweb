<?php

namespace DsWeb\Helper;

use DsWeb\Config;
use DsWeb\Data\AbstractData;
use DsWeb\Data\Mapping\AHMapping;

class AuctionHouseBotHelper extends AbstractData
{
    const MINUTE = 60;
    const HOUR = 60 * self::MINUTE;
    const DAY = 24 * self::HOUR;

    const BOT_NAME = 'DSPAH';
    const BOT_ID = 0;
    const BOT_EXPIRE_KEY = 'bot_expire_days';

    const AH_ITEMS_TO_TRY = 100;
    const AH_ITEMS_TO_BUY = 15;

    const MAX_ON_AUCTION_NORMAL = 5;
    const MAX_ON_AUCTION_ARMOR = 1;
    const MAX_ON_AUCTION_USEABLE = 20;

    const ARMOR_CATEGORIES = [
        AHMapping::AUTOMATON,
        AHMapping::AXES,
        AHMapping::BACK,
        AHMapping::BLACK_MAGIC,
        AHMapping::BODY,
        AHMapping::CLUBS,
        AHMapping::DAGGERS,
        AHMapping::DICE,
        AHMapping::EARRINGS,
        AHMapping::FEET,
        AHMapping::FISHING_GEAR,
        AHMapping::GEOMANCY,
        AHMapping::GREAT_AXES,
        AHMapping::GREAT_KATANA,
        AHMapping::GREAT_SWORDS,
        AHMapping::GRIPS,
        AHMapping::HAND_TO_HAND,
        AHMapping::HANDS,
        AHMapping::HEAD,
        AHMapping::INSTRUMENTS,
        AHMapping::KATANA,
        AHMapping::LEGS,
        AHMapping::NECK,
        AHMapping::NINJITSU,
        AHMapping::POLEARMS,
        AHMapping::RINGS,
        AHMapping::SCYTHES,
        AHMapping::SHIELDS,
        AHMapping::SONGS,
        AHMapping::STAVES,
        AHMapping::SUMMONING,
        AHMapping::SWORDS,
        AHMapping::WAIST,
        AHMapping::WHITE_MAGIC
    ];

    const USEABLE_CATEGORIES = [
        AHMapping::ALCHEMY,
        AHMapping::ALCHEMY_2,
        AHMapping::AMMUNITION,
        AHMapping::BONECRAFT,
        AHMapping::BREADS_AND_RICE,
        AHMapping::CLOTHCRAFT,
        AHMapping::CRYSTALS,
        AHMapping::DRINKS,
        AHMapping::FISH,
        AHMapping::GOLDSMITHING,
        AHMapping::INGREDIENTS,
        AHMapping::LEATHERCRAFT,
        AHMapping::MEAT_AND_EGGS,
        AHMapping::MEDICINES,
        AHMapping::NINJA_TOOLS,
        AHMapping::PET_ITEMS,
        AHMapping::RANGED,
        AHMapping::SEAFOOD,
        AHMapping::SMITHING,
        AHMapping::SOUPS,
        AHMapping::SWEETS,
        AHMapping::VEGETABLES,
        AHMapping::WOODWORKING
    ];

    const AH_TABLE = 'auction_house';
    const RESTOCK_FROM_TABLE = 'item_basic';

    const SERVER_TABLE = 'server_variables';
    const TREASURY_KEY = 'treasury_balance';
    const TREASURY_SETTING = 'server_treasury';


    public function buyRandomAhItems() {
        $treasuryBalance = $this->getTreasuryBalance();

        $alreadyOnAuction = $this->getCurrentAuctionItems();
        $ids = array_rand($alreadyOnAuction, self::AH_ITEMS_TO_BUY);
        foreach ($ids as $id) {
            $itemToBuy = null;
            $stack = time() % 2;
            $sql = "SELECT id, seller, seller_name, price FROM " . self::AH_TABLE . " WHERE itemid = ${id} AND sale = 0";
            if ((bool) $stack && $alreadyOnAuction[$id]['stack'] > 0) {
                // buy the stack
                $sql = "${sql} AND stack = 1";
            }
            $result = $this->getDb()->query($sql);
            if ($result) {
                $items = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($items as $item) {
                    if (empty($itemToBuy)) {
                        $itemToBuy = $item;
                    }
                    if ($itemToBuy['seller_name'] !== self::BOT_NAME) {
                        $itemToBuy = $item;
                        break;
                    }
                }
                $price = $itemToBuy['price'];
                $sellerId = $itemToBuy['seller'];
                $sellerName = $itemToBuy['seller_name'];
                if (($treasuryBalance - $price) > 0) {
                    echo "DEBUG: Buying {$itemToBuy['id']} from ${sellerName} for ${price} gil" . PHP_EOL;
                    $treasuryBalance -= $price;
                    $this->buyItem($itemToBuy['id'], $price, $sellerId, $sellerName);
                }
            }
        }
        $this->updateTreasuryBalance($treasuryBalance);
    }

    public function cleanUpAhDeliveryBox()
    {
        $table = 'delivery_box';
        $sql = "DELETE FROM ${table} WHERE charid = " . self::BOT_ID;

        $db = $this->getDb();
        return $db->query($sql);
    }

    public function expireOldBotListings()
    {
        $config = Config::getInstance();

        if ($ahConfig = $config->getAuctionHouseConfig()) {
            foreach ($ahConfig as $item) {
                $item = explode(':', trim($item));
                switch ($item[0]) {
                    case self::BOT_EXPIRE_KEY:
                        $duration = (int) $item[1];
                        break;
                }
                if (isset($duration)) {
                    break;
                }
            }

            $duration = $duration * self::DAY;
            $expirationDate = time() - $duration;
            $sql = "DELETE FROM auction_house WHERE seller = " .self::BOT_ID .
                    " AND date < ${expirationDate} AND sell_date = 0";

            if ($result = $this->getDb()->query($sql)) {
                echo "Debug: {$sql}" . PHP_EOL;
            }
        }
    }

    public function stockRandomAhItems()
    {
        $alreadyOnAuction = $this->getCurrentAuctionItems();
        $items = $this->getRandomItems();

        $lastIdUsed = $this->getLastIdUsedInAH();

        $db = $this->getDb();
        $sql = "INSERT INTO " . self::AH_TABLE . " VALUES (?,?,?,?,?,?,?,?,?,?)";
        $sellerId = self::BOT_ID;
        $sellerName = self::BOT_NAME;
        $buyerName = null;
        $sale = 0;
        $sellDate = 0;
        if ($statement = $db->prepare($sql)) {
            foreach ($items as $item) {
                $itemId = (int)$item['itemid'];
                $category = (int)$item['aH'];
                $armor = $this->isArmor($category);
                $useable = $this->isUseable($category);
                $stackable = (int)$item['stackSize'] > 1;
                $auctionNumSingle = $alreadyOnAuction[$itemId]['single'] ?? 0;
                $auctionNumStacks = $alreadyOnAuction[$itemId]['stack'] ?? 0;
                if ($useable) {
                    $maxOnAuction = self::MAX_ON_AUCTION_USEABLE;
                } elseif ($armor) {
                    $maxOnAuction = self::MAX_ON_AUCTION_ARMOR;
                } else {
                    $maxOnAuction = self::MAX_ON_AUCTION_NORMAL;
                }
                if (!$stackable) {
                    $listStack = false;
                } else {
                    $listStack = (time() % 2) === 1; // let the time of day determine if we list a stack or not
                }

                if (($listStack && $auctionNumStacks < $maxOnAuction) ||
                    ($auctionNumSingle < $maxOnAuction)) {
                    $id = ++$lastIdUsed; // should increment as we go
                    $price = $this->getSellPrice($itemId, (int) $item['BaseSell']);
                    $stack = (int) $stackable;
                    $timeSold = time();
                    if ($statement->bind_param(
                        'iiiisiisii',
                        $id,
                        $itemId,
                        $stack,
                        $sellerId,
                        $sellerName,
                        $timeSold,
                        $price,
                        $buyerName,
                        $sale,
                        $sellDate
                    )) {
                        echo "DEBUG: Inserting: {$item['name']}" . PHP_EOL;
                        $statement->execute();
                    }
                }
            }
        }
    }

    private function buyItem ($id, $price, $sellerId, $sellerName)
    {
        $sql = "UPDATE " . self::AH_TABLE . " SET buyer_name = '" . self::BOT_NAME . "', sale = ${price}, sell_date = " . time() . " WHERE id = ${id}";
        if ($this->getDb()->query($sql)) {
            if ($sellerName !== self::BOT_NAME) {
                $sql = "SELECT * FROM delivery_box WHERE charid = ${sellerId}";
                if ($result = $this->getDb()->query($sql)) {
                    $dbox = $result->fetch_all(MYSQLI_ASSOC);
                    $slot = count($dbox) % 8; // MAX slots
                }
                $sql = "INSERT INTO delivery_box (charid, charname, box, slot, itemid, itemsubid, quantity, extra, senderid, sender, received, sent)
                        VALUES (${sellerId}, '${sellerName}', 1, ${slot}, 65535, 0, ${price}, null, 0, 'AH-Jeuno', 0, 0)";
                if ($result = $this->getDb()->query($sql)) {
                    echo "DEBUG: ${sql}";
                }
            } else {
                // If the seller is the AHBOT, add the value to the treasury pool
                $treasuryBalance = $this->getTreasuryBalance() + $price;
                $this->updateTreasuryBalance($treasuryBalance);
            }
        }
    }

    private function getCurrentAuctionItems()
    {
        $sql = "SELECT * FROM " . self::AH_TABLE . " WHERE sell_date = 0";

        $result = $this->getDb()->query($sql);

        $ahItems = [];
        if ($result) {
            $items = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($items as $item) {
                $itemId = (int) $item['itemid'];
                if (!array_key_exists($itemId, $ahItems)) {
                    $ahItems[$itemId] = [
                        'single' => 0,
                        'stack' => 0
                    ];
                }
                $stack = ((int) $item['stack']) === 1;
                $key = $stack ? 'stack' : 'single';
                $ahItems[$itemId][$key]++;
            }
        }
        return $ahItems;
    }

    private function getLastIdUsedInAH()
    {
        $result = $this->getDb()->query('SELECT MAX(id) FROM ' . self::AH_TABLE);
        $lastId = $result->fetch_row();
        return (int) $lastId[0];
    }

    private function getMaxItemId()
    {
        $result = $this->getDb()->query('SELECT MAX(itemid) FROM ' . self::RESTOCK_FROM_TABLE);
        $lastId = $result->fetch_row();
        return (int) $lastId[0];
    }

    private function getRandomItems()
    {
        $maxId = $this->getMaxItemId();

        $randomIds = [];
        $i = 0;
        while ($i < self::AH_ITEMS_TO_TRY) {
            $random = rand(1, $maxId);
            if (!in_array($random, $randomIds)) {
                $randomIds[] = $random;
                $i++;
            }
        }
        $randomIds = '(' . implode(',', $randomIds) . ')';

        $sql = "SELECT * FROM " . self::RESTOCK_FROM_TABLE . " WHERE aH <> 0 AND itemid IN ${randomIds}";

        $result = $this->getDb()->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    private function getSellPrice($itemId, $baseSell)
    {
        $result = $this->getDb()->query('SELECT AVG(price) FROM ' . self::AH_TABLE . ' WHERE itemid = ' . $itemId . ' AND sale <> 0');
        $lastId = $result->fetch_row();
        $avgSellPrice = (int) $lastId[0];
        if ($avgSellPrice <= 0) {
            $avgSellPrice = $baseSell;
        }
        $highLow = time() % 3;
        $markup = $avgSellPrice * (float)('0.0' . rand(0, 9));
        if ($highLow === 2) {
            // Markup the item
            $price = round($avgSellPrice + $markup);
        } elseif ($highLow === 0) {
            // Mark down
            $price = floor($avgSellPrice - $markup);
        } else {
            // Sell at current value
            $price = $avgSellPrice;
        }
        if ((int) $price === 0) {
            // Finally, if sell price is still 0, just make it a random value rounded to the nearest hundreds
            $price = rand(100, 2000);
        }
        $precision = $price > 100 ? -2 : -1;
        $sell = round($price, $precision);
        return $sell;
    }

    private function getTreasuryBalance ()
    {
        $sql = 'SELECT value FROM ' . self::SERVER_TABLE . " WHERE name = '" . self::TREASURY_KEY . "'";
        $result = $this->getDb()->query($sql);
        if (!$result) {
            return false;
        }
        if (!$balance = $result->fetch_row()) {
            $this->updateTreasuryBalance(null); // Sets the default balance
            return $this->getTreasuryBalance();
        }
        return (int) $balance[0];

    }

    private function isArmor($category)
    {
        return in_array($category, self::ARMOR_CATEGORIES);
    }

    private function isUseable($category)
    {
        return in_array($category, self::USEABLE_CATEGORIES);
    }

    private function updateTreasuryBalance (int $balance = null)
    {
        if (!$balance) {
            $config = Config::getInstance();

            if ($ahConfig = $config->getAuctionHouseConfig()) {
                foreach ($ahConfig as $item) {
                    $item = explode(':', trim($item));
                    switch ($item[0]) {
                        case self::TREASURY_SETTING:
                            // Treasury settings is in millions
                            $balance = (int) $item[1] * 1000000;
                            break;
                    }
                    if (isset($balance)) {
                        break;
                    }
                }
            }
            if (!$balance) {
                return false;
            }
        }
        $sql = 'INSERT INTO ' . self::SERVER_TABLE . " (name, value)
                VALUES ('" . self::TREASURY_KEY . "', ${balance})
                ON DUPLICATE KEY UPDATE value = ${balance}";
        if ($result = $this->getDb()->query($sql)) {
            echo "Debug: {$sql}" . PHP_EOL;
        }

    }
}