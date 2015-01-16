<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowVariables extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetch("SHOW VARIABLES", Db::FETCH_ALL_NUM, ['Variable_name', 'Value']);
    }
}