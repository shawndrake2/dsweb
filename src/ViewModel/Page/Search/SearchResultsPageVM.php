<?php

namespace DsWeb\ViewModel\Page\Search;

use DsWeb\ViewModel\AbstractVM;

class SearchResultsPageVM extends AbstractVM
{
    public function __construct()
    {
        $this->setView('page/search/search-results-page');
    }
}