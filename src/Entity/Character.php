<?php

namespace DsWeb\Entity;

use DsWeb\Helper\TimeHelper;

class Character
{
    private $data;

    // Character data
    private $id;
    private $name;
    private $rotation;
    private $position;
    private $boundary;
    private $playtime;
    private $gmlevel;

    /** @var Account $account */
    public $account;

    /** @var Inventory $inventory */
    private $inventory;

    public function __construct($characterData)
    {
        $this->data = $characterData;
        $this->setupCharacterObject();
        $this->account = new Account($this->data['acc']);
    }

    private function setupCharacterObject()
    {
        $this->id           = $this->data['main']['id'];
        $this->name         = $this->data['main']['name'];
        $this->rotation     = $this->data['main']['rotation'];
        $this->position     = [
            'x' => $this->data['main']['x'],
            'y' => $this->data['main']['y'],
            'z' => $this->data['main']['z']
        ];
        $this->boundary     = $this->data['main']['boundary'];
        $this->playtime     = $this->data['main']['playtime'];
        $this->gmlevel      = $this->data['main']['gmlevel'];
    }

    public function getID() { return $this->id; }
    public function getName() { return $this->name; }
    public function getRotation() { return $this->rotation; }
    public function getPosition() { return $this->position; }
    public function getBoundary() { return $this->boundary; }
    public function getPlaytime() {
        $timeHelper = new TimeHelper();
        return $timeHelper->getPlaytimeAsString($this->playtime);
    }
    public function getGMLevel() { return $this->gmlevel; }

    public function getInventory() {
        return $this->inventory;
    }

    public function setInventory(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }
}
