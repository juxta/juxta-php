<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowViewProperties extends CommandAbstract
{
    public function run(Request $request)
    {
        $sql = "SELECT * FROM `INFORMATION_SCHEMA`.`VIEWS` WHERE `TABLE_SCHEMA` = '{$request['from']}' "
            . " AND `TABLE_NAME` = '{$request['view']}'";

        $properties = $this->db->fetchRow($sql, Db::FETCH_ASSOC);

        if (!empty($properties)) {
            $properties = array_change_key_case($properties, CASE_LOWER);
        }

        return $properties;
    }
}