<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowTriggers extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetch(
            "SHOW TRIGGERS FROM `{$request['from']}`",
            Db::FETCH_ALL_NUM,
            ['Trigger', 'Event', 'Timing', 'Table']
        );
    }
}