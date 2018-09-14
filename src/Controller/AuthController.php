<?php

namespace DsWeb\Controller;

use DsWeb\Data\AuthData;

class AuthController extends AbstractController
{
    public function login()
    {
        $charName = $_POST['characterName'] ?? null;
        $password = $_POST['password'] ?? null;

        $authData = new AuthData();
        $char = $authData->loginChar($charName, $password);

        $data['auth'] = !empty($char);
        if (!empty($char)) {
            $data['character'] = $char;
        }
        $this->outputData($data);
    }
}