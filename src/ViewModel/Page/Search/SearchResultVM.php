<?php

namespace DsWeb\ViewModel\Page\Search;

use DsWeb\ViewModel\AbstractVM;

class SearchResultVM extends AbstractVM
{
    public function __construct(array $result)
    {
        $this->setView('page/search/search-result');
    }
}