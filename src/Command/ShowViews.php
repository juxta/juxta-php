<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowViews extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll(
            "SELECT * FROM `INFORMATION_SCHEMA`.`VIEWS` WHERE `TABLE_SCHEMA` = '{$request['from']}'",
            ['TABLE_NAME', 'IS_UPDATABLE']
        );
    }
}