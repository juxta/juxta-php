<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowCharsets extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetch("SHOW CHARSET", Db::FETCH_ALL_NUM, ['Charset', 'Default collation', 'Description']);
    }
}