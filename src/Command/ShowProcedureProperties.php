<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowProcedureProperties extends CommandAbstract
{
    public function run(Request $request)
    {
        $sql = "SELECT * FROM `INFORMATION_SCHEMA`.`ROUTINES` WHERE `ROUTINE_SCHEMA` = '{$request['from']}' "
            . " AND `ROUTINE_NAME` = '{$request['procedure']}' AND ROUTINE_TYPE = 'PROCEDURE'";

        $properties = $this->db->fetch($sql, Db::FETCH_ROW_ASSOC);

        if (!empty($properties)) {
            $properties = array_change_key_case($properties, CASE_LOWER);
        }

        return $properties;
    }
}