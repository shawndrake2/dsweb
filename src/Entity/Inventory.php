<?php

namespace DsWeb\Entity;

class Inventory
{
    const GIL_ID = 65535;

    private $gil;
    private $inventory = [];

    public function getGil()
    {
        if (!$this->gil) {
            $this->gil = 0;
        }
        return $this->gil;
    }

    public function setGil(int $gil)
    {
        $this->gil = $gil;
    }

    public function getInventory()
    {
        return $this->inventory;
    }

    public function setInventory(array $inventory)
    {
        $this->inventory = $inventory;
    }

    public function setInventoryItem(array $inventoryItem)
    {
        if ($inventoryItem['itemId'] === self::GIL_ID) {
            $this->setGil($inventoryItem['quantity']);
        } else {
            $this->inventory[] = $inventoryItem;
        }
    }
}