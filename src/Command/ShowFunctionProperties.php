<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowFunctionProperties extends CommandAbstract
{
    public function run(Request $request)
    {
        $sql = "SELECT * FROM `INFORMATION_SCHEMA`.`ROUTINES` WHERE `ROUTINE_SCHEMA` = '{$request['from']}' "
            . " AND `ROUTINE_NAME` = '{$request['function']}' AND ROUTINE_TYPE = 'FUNCTION'";

        $properties = $this->db->fetchRow($sql, Db::FETCH_ASSOC);

        if (!empty($properties)) {
            $properties = array_change_key_case($properties, CASE_LOWER);
        }

        return $properties;
    }
}