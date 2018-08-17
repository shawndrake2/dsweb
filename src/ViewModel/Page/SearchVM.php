<?php

namespace DsWeb\ViewModel\Page;

use DsWeb\ViewModel\AbstractVM;

class SearchVM extends AbstractVM
{
    public function __construct()
    {
        $this->searchPlaceHolder = 'Type in a character name, skill, zone, mob. Search also accepts the same filters as ingame.';
        $this->searchDesc = 'Results will appear in realtime as you type (minimum 3 characters)';
        $this->setView('page/search');
    }
}