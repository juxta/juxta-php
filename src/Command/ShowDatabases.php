<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowDatabases extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetch("SHOW DATABASES", Db::FETCH_ALL_NUM);
    }
}