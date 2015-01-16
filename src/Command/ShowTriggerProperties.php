<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowTriggerProperties extends CommandAbstract
{
    public function run(Request $request)
    {
        $sql = "SELECT * FROM `INFORMATION_SCHEMA`.`TRIGGERS` WHERE `TRIGGER_SCHEMA` = '{$request['from']}' "
            . " AND `TRIGGER_NAME` = '{$request['trigger']}'";

        $properties = $this->db->fetch($sql, Db::FETCH_ROW_ASSOC);

        if (!empty($properties)) {
            $properties = array_change_key_case($properties, CASE_LOWER);
        }

        return $properties;
    }
}