<?php

use DsWeb\Data\CharacterData;
use DsWeb\ViewModel\Common\ErrorMessageVM;
use DsWeb\ViewModel\Page\CharacterEditVM;

require_once '../vendor/autoload.php';

// Get vars
$data = $_GET;

/*
    This file is specifically for characters, so things can be a bit
    more specific when accessing variables.
*/

// Gunna set vars just to clean things up
$id       = isset($data['uid']) ? trim($data['uid']) : null;
$action   = isset($data['action']) ? trim($data['action']) : null;

// Check to make sure an id
if ($id) {
    $options = [
        // Full includes things like account, session, zone, etc.
        'full'      => true,

        // Char specific
        'effects'   => true,
        'equip'     => true,
        'exp'       => true,
        'inventory' => true,
        'jobs'      => true,
        'look'      => true,
        'pet'       => true,
        'points'    => true,
        'profile'   => true,
        'skills'    => true,
        'stats'     => true,
        'sotrage'   => true,
        'vars'      => true,

        // Silly long one!
        'weapon_skill_points'     => true
    ];
    
    // Get character object
    $characterSearch = new CharacterData();
    $character = $characterSearch->get($id, $options);

    // If character, include view based on action
    if ($character) {
        $characterEditVM = new CharacterEditVM($character);
        echo $characterEditVM;
        var_dump($character);
    } else {
        $errorMessageVM = new ErrorMessageVM('Character could not be found.');
    }
} else {
    $errorMessageVM = new ErrorMessageVM('No character ID set.');
}

if (!empty($errorMessageVM)) {
    echo $errorMessageVM;
}
