<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowRoutines extends CommandAbstract
{
    public function run(Request $request)
    {
        $sql = "SELECT `ROUTINE_NAME`, LOWER(`ROUTINE_TYPE`) AS `ROUTINE_TYPE`, "
            . "`DEFINER`, `DTD_IDENTIFIER` "
            . "FROM `INFORMATION_SCHEMA`.`ROUTINES` "
            . "WHERE `ROUTINE_SCHEMA` = '{$request['from']}'";

        return $this->db->fetch($sql, Db::FETCH_ALL_NUM, ['ROUTINE_NAME', 'ROUTINE_TYPE', 'DTD_IDENTIFIER']);
    }
}