<?php

use DsWeb\Data\SearchData;
use DsWeb\ViewModel\Common\ErrorMessageVM;

require_once '../../vendor/autoload.php';

// Get vars
$params = $_GET;

// Make sure a search string exists
$searchString = $params['query'] ?? null;
if ($searchString) {
    $searchString = trim($searchString);
}

$categoryFilters = $params['categories'] ?? null;
if ($categoryFilters) {
    $filters['categories'] = explode(',', trim($categoryFilters)) ?? null;
}

// If no query exists, error, else all ok!
if (empty($searchString)) {
    $errorMessage = new ErrorMessageVM('No query found');
} else {
    // Start!
    $searchData = new SearchData();
    $results = $searchData->getSearchResults($searchString, $filters);

}

// Random functions to search
function searchCleanColumns($columns) {
    $arr = null;
    foreach($columns as $c) {
        $c = explode(" as ", $c);
        if (isset($c[1])) { $arr[] = $c[1]; } else { $arr[] = $c[0]; }
    }
    return $arr;
}
