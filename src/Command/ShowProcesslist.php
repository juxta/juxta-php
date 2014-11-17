<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowProcesslist extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll("SHOW PROCESSLIST", ['Id', 'User', 'Host', 'db', 'Command', 'Time', 'Info']);
    }
}