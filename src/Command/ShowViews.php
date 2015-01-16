<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowViews extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetch(
            "SELECT * FROM `INFORMATION_SCHEMA`.`VIEWS` WHERE `TABLE_SCHEMA` = '{$request['from']}'",
            Db::FETCH_ALL_NUM,
            ['TABLE_NAME', 'IS_UPDATABLE']
        );
    }
}