<?php

namespace DsWeb\ViewModel\Page;

use DsWeb\Character;
use DsWeb\ViewModel\AbstractVM;

class CharacterEditVM extends AbstractVM
{
    public function __construct(Character $character)
    {
        $this->account = $character->account;
        $this->character = $character;

        $this->setView('page/character-edit');
    }
}