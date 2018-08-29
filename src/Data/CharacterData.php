<?php

namespace DsWeb\Data;

use DsWeb\Data\Mapping\InventoryMapping;

class CharacterData extends AbstractData
{
    public function get($id, array $options = [])
    {
        // Options
        $full = isset($options['full']);

        if ($full) {
            $query = 'SELECT

                main.charid as main_id,
                main.charname as main_name,
                main.pos_rot as main_rotation,
                main.pos_x as main_x,
                main.pos_y as main_y,
                main.pos_z as main_z,
                main.boundary as main_boundary,
                main.playtime as main_playtime,
                main.gmlevel as main_gmlevel,

                acc.id as acc_id,
                acc.login as acc_name,
                acc.email as acc_email1,
                acc.email2 as acc_email2,
                acc.timecreate as acc_created,
                acc.timelastmodify as acc_modified,
                acc.status as acc_status,
                acc.priv as acc_privledges,

                session.linkshellid1 as session_linkshellid,
                session.client_addr as session_ip,
                session.client_port as session_port,

                zone.zoneid as zone_id,
                zone.name as zone_name

                FROM chars as main
                LEFT JOIN accounts as acc ON acc.id = main.accid
                LEFT JOIN accounts_sessions as session ON session.charid = main.charid
                LEFT JOIN zone_settings as zone ON zone.zoneid = main.pos_zone
                LEFT JOIN char_equip as equip ON equip.charid = main.charid
                LEFT JOIN char_exp as exp ON exp.charid = main.charid

                WHERE main.charid = ?
                LIMIT 0,1
            ';
        } else {
            $query = 'SELECT

                main.charid as main_id,
                main.charname as main_name,
                main.pos_rot as main_rotation,
                main.pos_x as main_x,
                main.pos_y as main_y,
                main.pos_z as main_z,
                main.boundary as main_boundary,
                main.playtime as main_playtime,
                main.gmlevel as main_gmlevel

                FROM chars as main
                WHERE main.charid = ?
                LIMIT 0,1';
        }

        // Get
        $db = $this->getDb();
        if ($statement = $db->prepare($query)) {
            $statement->bind_param('i', $id);
            $result = $statement->execute();
        }

        // If character data found
        if ($result) {
            // Set character variable to first entry
            $result = $statement->get_result();
            $character = $result->fetch_object();

            // Clean up data into formatted arrays
            $cleanedArray = [];
            foreach($character as $column => $value)
            {
                $column = explode("_", $column);
                $cleanedArray[$column[0]][$column[1]] = $value;
            }

            // Replace character with cleaned array
            $character = $cleanedArray;

            // Get all other data
            if ($options) {
                $allData = $this->getAllCharData($id, $options);

                // Merge all data with character array
                $character = array_merge($character, $allData);
            }

            // Final check, if all ok, MAKE DA OBJECTTTTTTTTTTT
            if (!empty($character['main']['id'])) {

                // Get inventory now
                $inventory = $this->getCharacterInventory($id);
                $character = array_merge($character, $inventory);
            }

            // Found but was borked?!
            return $character;
        }

        // Not found
        return false;
    }

    private function getAllCharData($id, $options)
    {
        // Data to return
        $data = [];

        // List of tables to query
        $tableList = [
            'effects',
            'equip',
            'exp',
            'inventory',
            'jobs',
            'look',
            'pet',
            'points',
            'profile',
            'skills',
            'stats',
            'storage',
            'vars'
        ];

        // Loop and get data
        $db = $this->getDb();
        foreach($tableList as $table) {
            // If option to get this data is yes
            if (isset($options[$table])) {
                // Add prefix
                $sqlTable = "char_${table}";
                // Query
                $query = "SELECT * FROM ${sqlTable} WHERE charid = ?";

                if ($statement = $db->prepare($query)) {
                    $statement->bind_param('i', $id);
                    $data[$table] = $statement->execute();
                }
            }
        }

        // Return data
        return $data;
    }

    private function getCharacterInventory($id)
    {
        $db = $this->getDb();
        $table = 'char_inventory';
        $query = "SELECT * FROM ${table} WHERE charid = ?";

        if ($statement = $db->prepare($query)) {
            $statement->bind_param('i', $id);
            if ($statement->execute()) {
                $results = $statement->get_result();
                $inventoryResults = $results->fetch_all(MYSQLI_ASSOC);
            }
        }

        foreach ($inventoryResults as $item) {
            if ($item['itemId'] === InventoryMapping::GIL_ID) {
                $inventory['gil'] = $item['quantity'];
            } else {
                $inventory['inventory'][$item['itemId']] = $item['quantity'];
            }
        }

        return $inventory;
    }
}
