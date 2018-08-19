<?php

namespace DsWeb\ViewModel\Page;

use DsWeb\Entity\Character;
use DsWeb\ViewModel\AbstractVM;

class CharacterEditVM extends AbstractVM
{
    public function __construct(Character $character)
    {
        $this->account = $character->account;
        $this->character = $character;
        $this->gil = $character->getInventory()->getGil();

        $this->setView('page/character-edit');
    }
}