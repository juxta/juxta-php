<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowProcesslist extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetch("SHOW PROCESSLIST", Db::FETCH_ALL_NUM, ['Id', 'User', 'Host', 'db', 'Command', 'Time', 'Info']);
    }
}