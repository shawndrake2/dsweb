<?php

namespace DsWeb\Data;

class AuthData extends AbstractData
{
    public function loginChar (string $charName = null, string $password = null)
    {
        if (!empty($charName) && !empty($password)) {
            $query = "
            SELECT chars.charid as id,
                   chars.charname as name
            FROM accounts acc 
            LEFT JOIN chars ON acc.id = chars.accid
            WHERE acc.login = '${charName}'
            AND acc.password = PASSWORD('${password}')";

            $result = $this->getDb()->query($query);
            while ($record = $result->fetch_assoc()) {
                $char = $record;
            }
        }

        return !empty($char) ? $char : [];
    }
}