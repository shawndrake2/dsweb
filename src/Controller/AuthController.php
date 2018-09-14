<?php

namespace DsWeb\Controller;

use DsWeb\Data\AuthData;

class AuthController extends AbstractController
{
    public function login()
    {
        // @TODO Stubbed out credentials for now
        $charName = 'ryken';
        $password = '*1FB4C5B3C86E9AF2D96D552E233FC218BA587298';

        $authData = new AuthData();
        $char = $authData->loginChar($charName, $password);

        $data['auth'] = !empty($char);
        if (!empty($char)) {
            $data['character'] = $char;
        }
        $this->outputData($data);
    }
}