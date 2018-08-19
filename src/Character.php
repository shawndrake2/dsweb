<?php

namespace DsWeb;

use DsWeb\Old\Funcs;

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

    public $account;

    public function __construct($characterData)
    {
        $this->data = $characterData;
        $this->setupCharacterObject();
        $this->account = new AccountObject($this->data['acc']);
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
    public function getPlaytime() { return (new Funcs)->duration($this->playtime); }
    public function getGMLevel() { return $this->gmlevel; }
}
