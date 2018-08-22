<?php

namespace DsWeb\Data;

class Junker extends AbstractData
{
    const GIL = 65535;
    const RYKEN = 21828;

    const ITEMS_TO_JUNK = [
        'hare_meat' => 4358
    ];

    public function sellJunk ()
    {
        $total = 0;
        $inventory = $this->getInventory();
        $junk = [];
        foreach ($inventory as $item) {
            $basePrice = $this->getBasePrice((int) $item['itemId']);
            $total += $basePrice;
            $junk[] = (int) $item['itemId'];
        }
        $this->removeFromInventory($junk);
        $this->payOutForItems($total);
    }

    public function payOutForItems ($payout)
    {
        $currentGil = $this->getCurrentGil();
        $newTotal = $currentGil + $payout;
        $sql = "UPDATE char_inventory SET quantity = ${newTotal} WHERE charid = " . self::RYKEN . " AND itemId = " . self::GIL;
        $this->getDb()->query($sql);
    }

    public function removeFromInventory ($items)
    {
        $items = implode(',', $items);
        $sql = "DELETE FROM char_inventory WHERE charid = " . self::RYKEN . " AND itemId IN (${items})";
        $this->getDb()->query($sql);
    }

    public function getCurrentGil ()
    {
        $sql = "SELECT * FROM char_inventory WHERE charid = " . self::RYKEN . " AND itemId = " . self::GIL;
        $result = $this->getDb()->query($sql);
        if ($result) {
            $gil = $result->fetch_assoc();
            return (int) $gil['quantity'];
        }
        return false;
    }

    public function getInventory ()
    {
        $junkItems = implode(',', self::ITEMS_TO_JUNK);
        $sql = "SELECT * FROM char_inventory WHERE charid = " . self::RYKEN . " AND itemId IN (${junkItems})";
        $result = $this->getDb()->query($sql);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function getBasePrice ($itemId)
    {
        $sql = "SELECT BaseSell FROM item_basic WHERE itemid = ${itemId}";
        $result = $this->getDb()->query($sql);
        if ($result) {
            $price = $result->fetch_row();
            return (int) $price[0];
        }
        return false;
    }
}