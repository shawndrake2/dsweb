<?php

namespace DsWeb\Controller;

use DsWeb\Data\CharacterData;

class CharacterController extends AbstractController
{
    const OPTIONS = [
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

    public function getCharacterInfo(array $params)
    {
        $data = [];
        $character = $params['id'];
        if ($character) {
            $characterSearch = new CharacterData();
            $characterData = $characterSearch->get($character, self::OPTIONS);
            $data = $characterData;
        }
        $this->outputData($data);
    }
}