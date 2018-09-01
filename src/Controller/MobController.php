<?php

namespace DsWeb\Controller;

use DsWeb\Data\MobData;

class MobController extends AbstractController
{
    public function getActiveNotoriousMonsters()
    {
        $mobData = new MobData();
        $data = $mobData->getActiveNotoriousMonsters();

        $this->outputData($data);
    }
}