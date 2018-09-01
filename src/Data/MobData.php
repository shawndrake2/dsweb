<?php

namespace DsWeb\Data;

class MobData extends AbstractData
{
    public function getActiveNotoriousMonsters()
    {
        $nms = [];
        $query = 'SELECT * from nm_tracker order by zone,name';

        $result = $this->getDb()->query($query);

        $currentZone = '';
        while ($record = $result->fetch_assoc()) {
            if ($record['zone'] !== $currentZone) {
                $currentZone = $record['zone'];
                $nms[$currentZone] = [];
            }
            $nms[$currentZone][] = $record;
        }
        return $nms;
    }
}
