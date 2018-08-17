<?php

namespace DsWeb\ViewModel\Page\Search;

use DsWeb\ViewModel\AbstractVM;

class SearchResultsSectionVM extends AbstractVM
{
    public function __construct()
    {
        $this->setView('page/search/search-results-section');
    }
}