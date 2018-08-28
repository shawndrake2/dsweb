<?php

namespace DsWeb\Controller;

use DsWeb\Data\SearchData;

class SearchController extends AbstractController
{
    public function getSearchResults()
    {
        $results = [];

        if ($searchString = $this->getSearchQuery()) {
            $filters = $this->getCategoryFilters();

            $searchData = new SearchData();
            $results = $searchData->getSearchResults($searchString, $filters);
        } else {
            $results['error'] = 'No query found';
        }
        $this->outputData($results);
    }

    private function getSearchQuery()
    {
        // Make sure a search string exists
        return $this->getQueryValue('query');
    }

    private function getCategoryFilters()
    {
        $filters = [];
        $categoryFilters = $this->getQueryValue('categories');
        if ($categoryFilters) {
            $filters['categories'] = explode(',', trim($categoryFilters)) ?? null;
        }
        return $filters;
    }
}