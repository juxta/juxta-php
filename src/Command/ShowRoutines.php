<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowRoutines extends CommandAbstract
{
    public function run(Request $request)
    {
        $sql = "SELECT `ROUTINE_NAME`, LOWER(`ROUTINE_TYPE`) AS `ROUTINE_TYPE`, "
            . "`DEFINER`, `DTD_IDENTIFIER` "
            . "FROM `INFORMATION_SCHEMA`.`ROUTINES` "
            . "WHERE `ROUTINE_SCHEMA` = '{$request['from']}'";

        return $this->db->fetchAll($sql, ['ROUTINE_NAME', 'ROUTINE_TYPE', 'DTD_IDENTIFIER']);
    }
}